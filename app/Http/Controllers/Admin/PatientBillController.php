<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientBill;
use App\Models\BillItem;
use App\Models\Patient;
use App\Models\PaymentGateway;
use App\Models\PatientPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientBillController extends Controller
{
    public function index(Request $request)
    {
        $bills = PatientBill::with(['patient', 'appointment'])
                    ->when($request->search, function($q) use ($request) {
                        $q->where('bill_number', 'LIKE', "%{$request->search}%")
                          ->orWhereHas('patient', function($q2) use ($request) {
                              $q2->where('first_name', 'LIKE', "%{$request->search}%")
                                ->orWhere('last_name', 'LIKE', "%{$request->search}%");
                          });
                    })
                    ->when($request->status, function($q) use ($request) {
                        $q->where('payment_status', $request->status);
                    })
                    ->latest()
                    ->paginate(15);

        return view('admin.bill.index', compact('bills'));
    }

    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        return view('admin.bill.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'bill_date' => 'required|date',
            'due_date' => 'nullable|date|after:bill_date',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.category' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $itemTotal = 0;
            $itemsData = [];
            foreach ($request->items as $item) {
                $total = $item['quantity'] * $item['unit_price'];
                $itemTotal += $total;
                $itemsData[] = [
                    'item_name' => $item['item_name'],
                    'description' => $item['description'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $total,
                    'category' => $item['category'] ?? null
                ];
            }

            $consultationFee = $request->consultation_fee ?? 0;
            $roomCharges = $request->room_charges ?? 0;
            $medicineCharges = $request->medicine_charges ?? 0;
            $labCharges = $request->lab_charges ?? 0;
            $operationCharges = $request->operation_charges ?? 0;
            $otherCharges = $request->other_charges ?? 0;

            $totalCharges = $consultationFee + $roomCharges + $medicineCharges + $labCharges + $operationCharges + $otherCharges;
            $totalAmount = $itemTotal + $totalCharges;

            $discount = $request->discount ?? 0;
            $taxPercent = $request->tax ?? 0;      
            $taxAmount = ($totalAmount * $taxPercent) / 100;
            $netAmount = $totalAmount - $discount + $taxAmount;

            $bill = PatientBill::create([
                'patient_id' => $request->patient_id,
                'appointment_id' => $request->appointment_id,
                'bill_number' => PatientBill::generateBillNumber(),
                'bill_date' => $request->bill_date,
                'due_date' => $request->due_date,
                'consultation_fee' => $consultationFee,
                'room_charges' => $roomCharges,
                'medicine_charges' => $medicineCharges,
                'lab_charges' => $labCharges,
                'operation_charges' => $operationCharges,
                'other_charges' => $otherCharges,
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'tax' => $taxPercent,      
                'net_amount' => $netAmount,
                'payment_status' => 'pending',
                'notes' => $request->notes
            ]);

            foreach ($itemsData as $item) {
                $bill->items()->create($item);
            }

            DB::commit();
            return redirect()->route('admin.bills.show', $bill)
                ->with('success', 'Bill created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show(PatientBill $bill)
    {
        $bill->load(['patient', 'appointment', 'items', 'payments.gateway']);
        $gateway = PaymentGateway::getActiveQR();
        return view('admin.bill.show', compact('bill', 'gateway'));
    }

    public function edit(PatientBill $bill)
    {
        $patients = Patient::orderBy('first_name')->get();
        return view('admin.bill.edit', compact('bill', 'patients'));
    }

    public function update(Request $request, PatientBill $bill)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'bill_date' => 'required|date',
            'due_date' => 'nullable|date|after:bill_date',
            'items' => 'sometimes|array',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.category' => 'nullable|string'
        ]);

        DB::beginTransaction();
    try {
        if ($request->has('items')) {
            $itemTotal = 0;
            foreach ($request->items as $item) {
                $total = $item['quantity'] * $item['unit_price'];
                $itemTotal += $total;
            }
        } else {
            $itemTotal = $bill->items->sum('total');
        }

        $consultationFee = $request->consultation_fee ?? $bill->consultation_fee;
        $roomCharges = $request->room_charges ?? $bill->room_charges;
        $medicineCharges = $request->medicine_charges ?? $bill->medicine_charges;
        $labCharges = $request->lab_charges ?? $bill->lab_charges;
        $operationCharges = $request->operation_charges ?? $bill->operation_charges;
        $otherCharges = $request->other_charges ?? $bill->other_charges;

        $totalCharges = $consultationFee + $roomCharges + $medicineCharges + $labCharges + $operationCharges + $otherCharges;
        $totalAmount = $itemTotal + $totalCharges;

        $discount = $request->discount ?? $bill->discount;
        $taxPercent = $request->tax ?? $bill->tax;
        $taxAmount = ($totalAmount * $taxPercent) / 100;
        $netAmount = $totalAmount - $discount + $taxAmount;

        $bill->update([
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'bill_date' => $request->bill_date,
            'due_date' => $request->due_date,
            'consultation_fee' => $consultationFee,
            'room_charges' => $roomCharges,
            'medicine_charges' => $medicineCharges,
            'lab_charges' => $labCharges,
            'operation_charges' => $operationCharges,
            'other_charges' => $otherCharges,
            'total_amount' => $totalAmount,
            'discount' => $discount,
            'tax' => $taxPercent,         
            'net_amount' => $netAmount,
            'notes' => $request->notes
        ]);

        DB::commit();
        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill updated successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}
    

    public function destroy(PatientBill $bill)
    {
        // Only allow deletion if bill is pending and no payment made
        if ($bill->payment_status !== 'pending') {
            return back()->with('error', 'Cannot delete a bill that has been paid or has payments.');
        }

        $bill->items()->delete();
        $bill->delete();

        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill deleted successfully!');
    }

    // Generate Invoice PDF
    public function generateInvoice(PatientBill $bill)
    {
        $bill->load(['patient', 'items']);
        $pdf = Pdf::loadView('admin.bill.invoice', compact('bill'));
        return $pdf->download('Invoice-' . $bill->bill_number . '.pdf');
    }

    // View Invoice
    public function viewInvoice(PatientBill $bill)
    {
        $bill->load(['patient', 'items']);
        return view('admin.bill.invoice', compact('bill'));
    }

    // Show QR Code for Payment
    public function showQR(PatientBill $bill)
    {
        $gateway = PaymentGateway::getActiveQR();
        if (!$gateway) {
            return response()->json(['error' => 'No active payment gateway found'], 404);
        }

        return response()->json([
            'bill_number' => $bill->bill_number,
            'amount' => $bill->net_amount,
            'qr_code' => $gateway->qr_code,
            'upi_id' => $gateway->upi_id,
            'account_holder' => $gateway->account_holder,
            'account_number' => $gateway->account_number,
            'ifsc_code' => $gateway->ifsc_code,
            'bank_name' => $gateway->bank_name,
            'gateway_name' => $gateway->name
        ]);
    }
    public function verifyPayment(Request $request, PatientBill $bill)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Update bill status
            $bill->update([
                'payment_status' => 'paid',
                'payment_method' => 'qr_code',
            ]);

            // Create payment record
            $bill->payments()->create([
                'transaction_id' => 'QR' . time() . rand(1000, 9999),
                'amount' => $request->amount,
                'currency' => 'INR',
                'payment_method' => 'qr_code',
                'status' => 'success',
                'paid_at' => now()
            ]);

            DB::commit();

            return redirect()->route('admin.bills.show', $bill)
                ->with('success', 'Payment verified successfully! Invoice generated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }
}