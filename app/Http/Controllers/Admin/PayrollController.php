<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\SalaryStructure;
use App\Services\SalaryCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $payrolls = Payroll::with(['employee', 'salaryStructure'])
            ->when($request->search, function($q) use ($request) {
                $q->whereHas('employee', function($q2) use ($request) {
                    $q2->where('first_name', 'LIKE', "%{$request->search}%")
                       ->orWhere('last_name', 'LIKE', "%{$request->search}%");
                });
            })
            ->when($request->month, function($q) use ($request) {
                $q->where('month_year', $request->month);
            })
            ->when($request->status, function($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.payroll.index', compact('payrolls'));
    }

    public function show(Payroll $payroll)
    {
        $payroll->load(['employee', 'items', 'salaryStructure']);
        return view('admin.payroll.show', compact('payroll'));
    }

    public function generatePayslip(Payroll $payroll)
    {
        $payroll->load(['employee', 'items', 'salaryStructure']);
        $pdf = Pdf::loadView('admin.payroll.payslip', compact('payroll'));
        return $pdf->download('Payslip-' . $payroll->employee->full_name . '-' . $payroll->month_year . '.pdf');
    }

    public function approve(Payroll $payroll)
    {
        $payroll->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Payroll approved successfully.');
    }

    public function markAsPaid(Request $request, Payroll $payroll)
    {
        $request->validate([
            'transaction_id' => 'nullable|string|max:255'
        ]);

        $payroll->update([
            'status' => 'paid',
            'payment_date' => now(),
            'transaction_id' => $request->transaction_id
        ]);

        return redirect()->back()->with('success', 'Payroll marked as paid.');
    }

    public function bulkPay(Request $request)
    {
        $request->validate([
            'payroll_ids' => 'required|array',
            'payroll_ids.*' => 'exists:payrolls,id'
        ]);

        DB::beginTransaction();
        try {
            Payroll::whereIn('id', $request->payroll_ids)
                ->where('status', 'approved')
                ->update([
                    'status' => 'paid',
                    'payment_date' => now()
                ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Payments processed successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function runPayrollGeneration()
    {
        \Artisan::call('payroll:generate');
        return back()->with('success', 'Payroll generation started. Check logs for details.');
    }
}