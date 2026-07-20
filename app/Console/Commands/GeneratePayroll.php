<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\User;
use App\Services\SalaryCalculationService;
use Carbon\Carbon;

class GeneratePayroll extends Command
{
    protected $signature = 'payroll:generate {--month=} {--year=} {--dry-run}';
    protected $description = 'Generate payroll for all employees for the given month';

    public function handle(SalaryCalculationService $salaryService)
    {
        $month = $this->option('month') ?? Carbon::now()->month;
        $year = $this->option('year') ?? Carbon::now()->year;
        $dryRun = $this->option('dry-run');

        $this->info("Generating payroll for Month: {$month}, Year: {$year}");

        // Get all employees with salary structures
        $employees = $this->getAllEmployees();

        $count = 0;
        foreach ($employees as $employee) {
            try {
                if ($dryRun) {
                    $this->info("Dry run: Would generate payroll for {$employee->full_name}");
                    $count++;
                    continue;
                }

                // Check if payroll already exists
                $existing = $employee->payrolls()
                    ->where('month_year', Carbon::create($year, $month, 1)->format('Y-m'))
                    ->first();

                if ($existing) {
                    $this->warn("Payroll already exists for {$employee->full_name} - Skipping");
                    continue;
                }

                $payroll = $salaryService->calculatePayroll($employee, $month, $year);
                $this->info("Generated payroll for {$employee->full_name}: {$payroll->net_payable}");

                $count++;
            } catch (\Exception $e) {
                $this->error("Error for {$employee->full_name}: " . $e->getMessage());
            }
        }

        $this->info("Payroll generation completed. Processed: {$count} employees.");
    }

    private function getAllEmployees()
    {
        $employees = collect();

        // Get Doctors
        $doctors = Doctor::whereHas('salaryStructure')->get();
        foreach ($doctors as $doctor) {
            $employees->push($doctor);
        }

        // Get Employees
        $staff = Employee::whereHas('salaryStructure')->get();
        foreach ($staff as $employee) {
            $employees->push($employee);
        }

        return $employees;
    }
}