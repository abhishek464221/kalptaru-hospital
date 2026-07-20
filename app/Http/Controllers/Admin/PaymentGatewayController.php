<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $gateways = PaymentGateway::orderBy('display_order')->paginate(10);
        return view('admin.payment-gateway.index', compact('gateways'));
    }

    public function create()
    {
        return view('admin.payment-gateway.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:qr,gateway,bank',
            'mode' => 'required|in:test,live',
            'key' => 'nullable|string',
            'secret' => 'nullable|string',
            'upi_id' => 'nullable|string|max:255',
            'account_holder' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'is_active' => 'sometimes|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['settings'] = $request->settings ?? [];

        // Encrypt sensitive data
        if ($request->key) {
            $data['key'] = $request->key; // Model encrypts automatically
        }
        if ($request->secret) {
            $data['secret'] = $request->secret; // Model encrypts automatically
        }

        // Upload QR Code
        if ($request->hasFile('qr_code')) {
            $path = $request->file('qr_code')->store('payment_qr', 'public');
            $data['qr_code'] = $path;
        }

        PaymentGateway::create($data);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Payment Gateway created successfully.');
    }

    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.payment-gateway.edit', compact('paymentGateway'));
    }

    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:qr,gateway,bank',
            'mode' => 'required|in:test,live',
            'key' => 'nullable|string',
            'secret' => 'nullable|string',
            'upi_id' => 'nullable|string|max:255',
            'account_holder' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'is_active' => 'sometimes|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['settings'] = $request->settings ?? [];

        // Encrypt sensitive data
        if ($request->key) {
            $data['key'] = $request->key;
        }
        if ($request->secret) {
            $data['secret'] = $request->secret;
        }

        // Upload QR Code
        if ($request->hasFile('qr_code')) {
            // Delete old QR
            if ($paymentGateway->qr_code && Storage::disk('public')->exists($paymentGateway->qr_code)) {
                Storage::disk('public')->delete($paymentGateway->qr_code);
            }
            $path = $request->file('qr_code')->store('payment_qr', 'public');
            $data['qr_code'] = $path;
        }

        $paymentGateway->update($data);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Payment Gateway updated successfully.');
    }

    public function destroy(PaymentGateway $paymentGateway)
    {
        // Delete QR image
        if ($paymentGateway->qr_code && Storage::disk('public')->exists($paymentGateway->qr_code)) {
            Storage::disk('public')->delete($paymentGateway->qr_code);
        }

        $paymentGateway->delete();

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Payment Gateway deleted successfully.');
    }

    public function toggleStatus(PaymentGateway $paymentGateway)
    {
        $paymentGateway->update(['is_active' => !$paymentGateway->is_active]);
        
        return response()->json([
            'success' => true,
            'status' => $paymentGateway->is_active ? 'active' : 'inactive'
        ]);
    }
}