<?php

namespace App\Services;

use App\Models\SalaryStructure;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\Appointment;
use App\Models\Attendance;
use Carbon\Carbon;

class SalaryCalculationService
{
    public function calculatePayroll($employee, $month, $year)
    {
        $salaryStructure = $employee->salaryStructure;
        
        if (!$salaryStructure) {
            throw new \Exception('No active salary structure found for employee.');
        }

        $monthYear = Carbon::create($year, $month, 1);

        // Get base salary
        $baseSalary = $salaryStructure->base_salary;

        // Calculate allowances
        $allowances = $salaryStructure->allowances ?? [];
        $totalAllowances = array_sum($allowances);

        // Calculate variable components based on employee type
        $variableEarnings = $this->calculateVariableEarnings($employee, $salaryStructure, $monthYear);

        // Calculate deductions
        $deductions = $salaryStructure->deductions ?? [];
        $totalDeductions = array_sum($deductions);

        // Calculate total earnings
        $totalEarnings = $baseSalary + $totalAllowances + $variableEarnings;
        $netPayable = $totalEarnings - $totalDeductions;

        // Create payroll record
        $payroll = Payroll::create([
            'employee_id' => $employee->id,
            'employee_type' => get_class($employee),
            'salary_structure_id' => $salaryStructure->id,
            'month_year' => $monthYear->format('Y-m'),
            'total_earnings' => $totalEarnings,
            'total_deductions' => $totalDeductions,
            'net_payable' => $netPayable,
            'status' => 'draft'
        ]);

        // Create payroll items
        $this->createPayrollItems($payroll, $employee, $salaryStructure, $monthYear);

        return $payroll;
    }

    private function calculateVariableEarnings($employee, $salaryStructure, $monthYear)
    {
        $variableComponents = $salaryStructure->variable_components ?? [];
        $variableEarnings = 0;

        // For Doctors: Calculate consultation fees
        if ($employee instanceof \App\Models\Doctor) {
            if (isset($variableComponents['per_consultation'])) {
                $consultations = Appointment::where('doctor_id', $employee->id)
                    ->whereMonth('appointment_date', $monthYear->month)
                    ->whereYear('appointment_date', $monthYear->year)
                    ->where('status', 'completed')
                    ->count();
                
                $variableEarnings += $consultations * $variableComponents['per_consultation'];
            }
        }

        // For Managers: Calculate performance bonus
        if ($employee instanceof \App\Models\Employee && $employee->role == 'manager') {
            if (isset($variableComponents['bonus_percent'])) {
                // Example: Calculate based on department performance
                // You can implement your own logic here
                $performanceScore = $this->calculateManagerPerformance($employee, $monthYear);
                $variableEarnings += ($salaryStructure->base_salary * $variableComponents['bonus_percent'] / 100) * $performanceScore;
            }
        }

        // For Staff: Calculate overtime
        if ($employee instanceof \App\Models\Employee && isset($variableComponents['overtime_rate'])) {
            $overtimeHours = $this->calculateOvertimeHours($employee, $monthYear);
            $variableEarnings += $overtimeHours * $variableComponents['overtime_rate'];
        }

        return $variableEarnings;
    }

    private function calculateOvertimeHours($employee, $monthYear)
    {
        // Example: Check attendance records for overtime
        return Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $monthYear->month)
            ->whereYear('date', $monthYear->year)
            ->sum('overtime_hours') ?? 0;
    }

    private function calculateManagerPerformance($employee, $monthYear)
    {
        // Example logic - implement your own
        // Based on department KPIs, revenue, patient satisfaction, etc.
        return 1; // Placeholder: 1 = 100% performance
    }

    private function createPayrollItems($payroll, $employee, $salaryStructure, $monthYear)
    {
        $items = [];

        // Base Salary
        $items[] = [
            'payroll_id' => $payroll->id,
            'label' => 'Base Salary',
            'type' => 'earning',
            'amount' => $salaryStructure->base_salary,
            'source' => 'base_salary'
        ];

        // Allowances
        foreach ($salaryStructure->allowances ?? [] as $key => $value) {
            $items[] = [
                'payroll_id' => $payroll->id,
                'label' => ucwords(str_replace('_', ' ', $key)),
                'type' => 'earning',
                'amount' => $value,
                'source' => 'allowance'
            ];
        }

        // Variable Earnings (if any)
        if (isset($variableEarnings) && $variableEarnings > 0) {
            $items[] = [
                'payroll_id' => $payroll->id,
                'label' => 'Variable Earnings',
                'type' => 'earning',
                'amount' => $variableEarnings ?? 0,
                'source' => 'variable'
            ];
        }

        // Deductions
        foreach ($salaryStructure->deductions ?? [] as $key => $value) {
            $items[] = [
                'payroll_id' => $payroll->id,
                'label' => ucwords(str_replace('_', ' ', $key)),
                'type' => 'deduction',
                'amount' => $value,
                'source' => 'deduction'
            ];
        }

        PayrollItem::insert($items);
    }

    public function approvePayroll(Payroll $payroll)
    {
        $payroll->update(['status' => 'approved']);
        return $payroll;
    }

    public function markAsPaid(Payroll $payroll, $transactionId = null)
    {
        $payroll->update([
            'status' => 'paid',
            'payment_date' => now(),
            'transaction_id' => $transactionId
        ]);
        return $payroll;
    }
}