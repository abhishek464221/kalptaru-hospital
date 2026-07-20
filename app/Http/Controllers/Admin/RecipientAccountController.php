<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecipientAccount;
use App\Models\Doctor;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipientAccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = RecipientAccount::with('recipientable')
            ->when($request->search, function($q) use ($request) {
                $q->whereHas('recipientable', function($q2) use ($request) {
                    $q2->where('first_name', 'LIKE', "%{$request->search}%")
                       ->orWhere('last_name', 'LIKE', "%{$request->search}%");
                });
            })
            ->orderBy('display_order')
            ->paginate(15);

        return view('admin.recipient-account.index', compact('accounts'));
    }

    public function create()
    {
        $doctors = Doctor::select('id', 'first_name', 'last_name')->get();
        $employees = Employee::select('id', 'first_name', 'last_name')->get();

        $recipients = [
            'doctor' => $doctors,
            'employee' => $employees,
        ];

        return view('admin.recipient-account.create', compact('recipients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:doctor,employee',
            'recipient_id' => 'required|integer',
            'account_holder_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'upi_id' => 'nullable|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'is_active' => 'sometimes|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $typeMap = [
            'doctor' => Doctor::class,
            'employee' => Employee::class,
        ];

        $data = $request->all();
        $data['recipientable_type'] = $typeMap[$request->recipient_type];
        $data['recipientable_id'] = $request->recipient_id;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['settings'] = $request->settings ?? [];

        // Upload QR Code
        if ($request->hasFile('qr_code')) {
            $path = $request->file('qr_code')->store('recipient_qr', 'public');
            $data['qr_code'] = $path;
        }

        RecipientAccount::create($data);

        return redirect()->route('admin.recipient-accounts.index')
            ->with('success', 'Recipient Account created successfully.');
    }

    public function edit(RecipientAccount $recipientAccount)
    {
        $doctors = Doctor::select('id', 'first_name', 'last_name')->get();
        $employees = Employee::select('id', 'first_name', 'last_name')->get();

        $recipients = [
            'doctor' => $doctors,
            'employee' => $employees,
        ];

        $currentType = class_basename($recipientAccount->recipientable_type);
        $currentTypeLower = strtolower($currentType);

        return view('admin.recipient-account.edit', compact('recipientAccount', 'recipients', 'currentTypeLower'));
    }

    public function update(Request $request, RecipientAccount $recipientAccount)
    {
        $request->validate([
            'recipient_type' => 'required|in:doctor,employee',
            'recipient_id' => 'required|integer',
            'account_holder_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'upi_id' => 'nullable|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'is_active' => 'sometimes|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $typeMap = [
            'doctor' => Doctor::class,
            'employee' => Employee::class,
        ];

        $data = $request->all();
        $data['recipientable_type'] = $typeMap[$request->recipient_type];
        $data['recipientable_id'] = $request->recipient_id;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['settings'] = $request->settings ?? [];

        // Upload QR Code
        if ($request->hasFile('qr_code')) {
            if ($recipientAccount->qr_code && Storage::disk('public')->exists($recipientAccount->qr_code)) {
                Storage::disk('public')->delete($recipientAccount->qr_code);
            }
            $path = $request->file('qr_code')->store('recipient_qr', 'public');
            $data['qr_code'] = $path;
        }

        $recipientAccount->update($data);

        return redirect()->route('admin.recipient-accounts.index')
            ->with('success', 'Recipient Account updated successfully.');
    }

    public function destroy(RecipientAccount $recipientAccount)
    {
        if ($recipientAccount->qr_code && Storage::disk('public')->exists($recipientAccount->qr_code)) {
            Storage::disk('public')->delete($recipientAccount->qr_code);
        }
        $recipientAccount->delete();

        return redirect()->route('admin.recipient-accounts.index')
            ->with('success', 'Recipient Account deleted successfully.');
    }

    public function toggleStatus(RecipientAccount $recipientAccount)
    {
        $recipientAccount->update(['is_active' => !$recipientAccount->is_active]);
        return response()->json([
            'success' => true,
            'status' => $recipientAccount->is_active ? 'active' : 'inactive'
        ]);
    }

    // AJAX: Get recipients by type
    public function getRecipients(Request $request)
    {
        $type = $request->type;
        if ($type == 'doctor') {
            $list = Doctor::select('id', 'first_name', 'last_name')->orderBy('first_name')->get()
                ->map(fn($item) => ['id' => $item->id, 'name' => $item->full_name]);
        } elseif ($type == 'employee') {
            $list = Employee::select('id', 'first_name', 'last_name')->orderBy('first_name')->get()
                ->map(fn($item) => ['id' => $item->id, 'name' => $item->full_name]);
        } else {
            return response()->json([]);
        }
        return response()->json($list);
    }
}