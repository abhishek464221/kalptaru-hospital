<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index()
    {
        $payments = Payment::with(['patient', 'appointment'])->get();
        return view('admin.payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::all();
        return view('admin.payment.create', compact('patients', 'appointments'));
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,bank_transfer,cheque,online',
            'status' => 'required|in:paid,pending,partial,refunded',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['invoice_number'] = Payment::generateInvoiceNumber();
        $data['net_amount'] = $request->amount - $request->discount + $request->tax;

        Payment::create($data);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment created successfully.');
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment)
    {
        $patients = Patient::all();
        $appointments = Appointment::all();
        return view('admin.payment.edit', compact('payment', 'patients', 'appointments'));
    }

    /**
     * Update the specified payment.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,bank_transfer,cheque,online',
            'status' => 'required|in:paid,pending,partial,refunded',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['net_amount'] = $request->amount - $request->discount + $request->tax;

        $payment->update($data);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}