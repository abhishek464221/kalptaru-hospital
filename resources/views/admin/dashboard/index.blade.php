@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Top Stats Cards -->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                    <div class="dash-widget-info text-right">
                        <h3>{{ $totalDoctors }}</h3>
                        <span class="widget-title1">Doctors <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                    <div class="dash-widget-info text-right">
                        <h3>{{ $totalPatients }}</h3>
                        <span class="widget-title2">Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                    <div class="dash-widget-info text-right">
                        <h3>{{ $totalEmployees }}</h3>
                        <span class="widget-title3">Employees <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                    <div class="dash-widget-info text-right">
                        <h3>{{ $pendingAppointments }}</h3>
                        <span class="widget-title4">Pending <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Line Chart -->
            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title">
                            <h4>Patient Total</h4>
                            <span class="float-right">
                                <i class="fa fa-{{ $percentageChange >= 0 ? 'caret-up' : 'caret-down' }}" aria-hidden="true"></i>
                                {{ abs($percentageChange) }}% {{ $trendText }}
                            </span>
                        </div>
                        <canvas id="linegraph"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bar Chart with Checkboxes -->
            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title">
                            <h4>Patients In</h4>
                            <div class="float-right">
                                <!-- Checkbox Buttons -->
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-primary active" id="toggle-opd">
                                        <input type="checkbox" checked autocomplete="off"> OPD
                                    </label>
                                    <label class="btn btn-outline-info active" id="toggle-ipd">
                                        <input type="checkbox" checked autocomplete="off"> IPD
                                    </label>
                                    <label class="btn btn-outline-warning active" id="toggle-icu">
                                        <input type="checkbox" checked autocomplete="off"> ICU
                                    </label>
                                </div>
                            </div>
                        </div>
                        <canvas id="bargraph"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments & Recent Doctors -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">Upcoming Appointments</h4>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-primary float-right">View all</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="d-none">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Doctor Name</th>
                                        <th>Timing</th>
                                        <th class="text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($upcomingAppointments as $appointment)
                                        <tr>
                                            <td style="min-width: 200px;">
                                                <a class="avatar" href="#">
                                                    {{ strtoupper(substr($appointment->patient->first_name ?? 'N', 0, 1)) }}
                                                </a>
                                                <h2>
                                                    <a href="#">
                                                        {{ $appointment->patient->full_name ?? 'N/A' }}
                                                        <span>{{ $appointment->patient->address ?? '' }}</span>
                                                    </a>
                                                </h2>
                                            </td>
                                            <td>
                                                <h5 class="time-title p-0">Appointment With</h5>
                                                <p>Dr. {{ $appointment->doctor->full_name ?? 'N/A' }}</p>
                                            </td>
                                            <td>
                                                <h5 class="time-title p-0">Timing</h5>
                                                <p>{{ $appointment->appointment_date->format('d M Y') }}, {{ $appointment->appointment_time->format('h:i A') }}</p>
                                            </td>
                                            <td class="text-right">
                                                <span class="badge badge-{{ $appointment->status == 'pending' ? 'warning' : ($appointment->status == 'confirmed' ? 'info' : 'success') }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No upcoming appointments</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                <div class="card member-panel">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">Doctors</h4>
                    </div>
                    <div class="card-body">
                        <ul class="contact-list">
                            @forelse($recentDoctors as $doctor)
                                <li>
                                    <div class="contact-cont">
                                        <div class="float-left user-img m-r-10">
                                            <a href="#" title="{{ $doctor->full_name }}">
                                                @php
                                                    $img = url($doctor->image);
                                                @endphp
                                                <img src="{{ $img }}" alt="" class="w-40 rounded-circle">
                                                <span class="status online"></span>
                                            </a>
                                        </div>
                                        <div class="contact-info">
                                            <span class="contact-name text-ellipsis">Dr. {{ $doctor->full_name }}</span>
                                            <span class="contact-date">{{ $doctor->specialization }}</span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li>No doctors found</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a href="{{ route('admin.doctors.index') }}" class="text-muted">View all Doctors</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">New Patients</h4>
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-primary float-right">View all</a>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table mb-0 new-patient-table">
                                <tbody>
                                    @forelse($recentPatients as $patient)
                                        <tr>
                                            <td>
                                                <h2>{{ $patient->full_name }}</h2>
                                            </td>
                                            <td>{{ $patient->email ?? 'N/A' }}</td>
                                            <td>{{ $patient->phone }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-primary-one float-right">
                                                    {{ $patient->patient_type ?? 'General' }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No patients found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                <div class="hospital-barchart">
                    <h4 class="card-title d-inline-block">Hospital Management</h4>
                </div>
                <div class="bar-chart">
                    <div class="legend">
                        @foreach($hospitalStats as $stat)
                            <div class="item">
                                <h4>{{ $stat['label'] }} ({{ $stat['count'] }})</h4>
                            </div>
                        @endforeach
                    </div>
                    <div class="chart clearfix">
                        @foreach($hospitalStats as $stat)
                            <div class="item">
                                <div class="bar">
                                    <span class="percent">{{ $stat['percent'] }}%</span>
                                    <div class="item-progress" data-percent="{{ $stat['percent'] }}" style="width: {{ $stat['percent'] }}%;">
                                        <span class="title">{{ $stat['label'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var ctx1 = document.getElementById('linegraph').getContext('2d');
    var lineChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($patientChartLabels),
            datasets: [{
                label: 'Patients',
                data: @json($patientChartData),
                backgroundColor: 'rgba(13, 110, 253, 0.2)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(13, 110, 253, 1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });

    var ctx2 = document.getElementById('bargraph').getContext('2d');
    var barChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['OPD', 'IPD', 'ICU'],
            datasets: [
                {
                    label: 'OPD',
                    data: [{{ $opdCount }}, 0, 0],
                    backgroundColor: '#0d6efd',
                    borderColor: '#0d6efd',
                    borderWidth: 1
                },
                {
                    label: 'IPD',
                    data: [0, {{ $ipdCount }}, 0],
                    backgroundColor: '#17a2b8',
                    borderColor: '#17a2b8',
                    borderWidth: 1
                },
                {
                    label: 'ICU',
                    data: [0, 0, {{ $icuCount }}],
                    backgroundColor: '#ffc107',
                    borderColor: '#ffc107',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });

    const toggleLabels = document.querySelectorAll('.btn-group-toggle .btn');
    toggleLabels.forEach((label, index) => {
        const checkbox = label.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.addEventListener('change', function(e) {
                if (this.checked) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
                barChart.data.datasets[index].hidden = !this.checked;
                barChart.update();
            });
        }
    });
</script>
@endpush