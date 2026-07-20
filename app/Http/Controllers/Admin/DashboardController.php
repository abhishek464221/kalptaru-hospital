<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();
        $totalEmployees = Employee::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', '>=', today())
            ->orderBy('appointment_date', 'asc')
            ->limit(5)
            ->get();

        // Recent Doctors (with image)
        $doctorColumns = ['id', 'first_name', 'last_name', 'specialization'];
        if (Schema::hasColumn('doctors', 'image')) {
            $doctorColumns[] = 'image';
        }
        $recentDoctors = Doctor::select($doctorColumns)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Recent Patients (with image)
        $patientColumns = ['id', 'first_name', 'last_name', 'email', 'phone', 'medical_history', 'patient_type'];
        if (Schema::hasColumn('patients', 'image')) {
            $patientColumns[] = 'image';
        } elseif (Schema::hasColumn('patients', 'profile_image')) {
            $patientColumns[] = 'profile_image';
        }
        $recentPatients = Patient::select($patientColumns)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Line Chart Data (Last 6 Months)
        $patientChartLabels = [];
        $patientChartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $patientChartLabels[] = $month->format('M Y');
            $count = Patient::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $patientChartData[] = $count;
        }

        // ---- Patients In (Bar Chart) – Individual Counts ----
        $opdCount = Patient::where('patient_type', 'OPD')->count();
        $ipdCount = Patient::where('patient_type', 'IPD')->count();
        $icuCount = Patient::where('patient_type', 'ICU')->count();

        // Dynamic Trend (this month vs last month)
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $thisMonthCount = Patient::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $lastMonth = now()->subMonth();
        $lastMonthCount = Patient::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $percentageChange = 0;
        $trendText = '';
        if ($lastMonthCount > 0) {
            $percentageChange = round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100);
            $trendText = ($percentageChange >= 0) ? "Higher than Last Month" : "Lower than Last Month";
        } else {
            $trendText = "No data for last month";
        }

        // Hospital Management Stats
        $newPatientCount = $thisMonthCount;
        $labTestCount = 0;
        if (Schema::hasColumn('appointments', 'department')) {
            $labTestCount = Appointment::where('department', 'Laboratory')->count();
        }
        $treatmentCount = Appointment::whereIn('status', ['confirmed', 'completed'])->count();
        $dischargeCount = 0;
        if (Schema::hasColumn('patients', 'discharged_at')) {
            $dischargeCount = Patient::whereNotNull('discharged_at')->count();
        } elseif (Schema::hasColumn('patients', 'status')) {
            $dischargeCount = Patient::where('status', 'discharged')->count();
        }

        $totalPatientsForPercent = $totalPatients > 0 ? $totalPatients : 1;
        $hospitalStats = [
            ['label' => 'OPD Patient', 'count' => $opdCount, 'percent' => round(($opdCount / $totalPatientsForPercent) * 100)],
            ['label' => 'New Patient', 'count' => $newPatientCount, 'percent' => round(($newPatientCount / $totalPatientsForPercent) * 100)],
            ['label' => 'Laboratory Test', 'count' => $labTestCount, 'percent' => round(($labTestCount / $totalPatientsForPercent) * 100)],
            ['label' => 'Treatment', 'count' => $treatmentCount, 'percent' => round(($treatmentCount / $totalPatientsForPercent) * 100)],
            ['label' => 'Discharge', 'count' => $dischargeCount, 'percent' => round(($dischargeCount / $totalPatientsForPercent) * 100)],
        ];

        return view('admin.dashboard.index', compact(
            'totalDoctors',
            'totalPatients',
            'totalEmployees',
            'pendingAppointments',
            'upcomingAppointments',
            'recentDoctors',
            'recentPatients',
            'patientChartLabels',
            'patientChartData',
            'opdCount',
            'ipdCount',
            'icuCount',
            'percentageChange',
            'trendText',
            'hospitalStats'
        ));
    }
}