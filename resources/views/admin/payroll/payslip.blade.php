<!DOCTYPE html>
<html>
<head>
    <title>Payslip - {{ $payroll->employee->full_name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            padding: 15px 20px;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-left img {
            max-height: 55px;
        }
        .company-info .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
        .company-info .company-details {
            font-size: 11px;
            color: #555;
        }
        .header-right {
            text-align: right;
            font-size: 11px;
            line-height: 1.6;
        }
        .header-right .payslip-title {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }
        .details {
            margin: 8px 0;
        }
        .details table {
            width: 100%;
        }
        .details td {
            padding: 3px 0;
            font-size: 11px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 11px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 5px 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 10px;
        }
        .total-section {
            margin: 8px 0;
            text-align: right;
            font-size: 12px;
        }
        .total-section table {
            float: right;
        }
        .total-section td {
            padding: 3px 10px;
        }
        .grand-total {
            font-size: 16px;
            font-weight: bold;
            color: #27ae60;
        }
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            clear: both;
        }
        .status-draft { color: #f39c12; font-weight: bold; }
        .status-approved { color: #3498db; font-weight: bold; }
        .status-paid { color: #27ae60; font-weight: bold; }
        .status-cancelled { color: #e74c3c; font-weight: bold; }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 70px;
            opacity: 0.04;
            z-index: -1;
            color: #333;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0 5px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }
        .summary-box {
            background: #f9f9f9;
            padding: 8px 12px;
            border-left: 3px solid #2c3e50;
            margin: 5px 0;
        }
        .summary-box table {
            width: 100%;
        }
        .summary-box td {
            padding: 2px 8px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="watermark">PAYSLIP</div>

    @php
        // ===== HOSPITAL SETTINGS =====
        $hospital_name = \App\Models\Setting::get('company_name') ?? 'Kalptaru Hospital';
        $hospital_address = \App\Models\Setting::get('address') ?? 'Address Line 1, City, State - PIN';
        $hospital_phone = \App\Models\Setting::get('phone') ?? '+91-XXXXXXXXXX';
        $hospital_email = \App\Models\Setting::get('email') ?? 'info@hospital.com';

        // ===== LOGO =====
        $logoPath = \App\Models\Setting::get('logo_header');
        $logo_url = $logoPath ? public_path('storage/' . $logoPath) : '';
        $default_logo = public_path('assets/img/logo.png');
        $final_logo = ($logo_url && file_exists($logo_url)) ? $logo_url : $default_logo;
    @endphp

    <div class="header">
        <div class="header-left">
            @if(file_exists($final_logo))
                <img src="{{ $final_logo }}" alt="Logo">
            @else
                <div style="font-size:20px; font-weight:bold; color:#2c3e50;">{{ $hospital_name }}</div>
            @endif
            <div class="company-info">
                <div class="company-name">{{ $hospital_name }}</div>
                <div class="company-details">{{ $hospital_address }}</div>
                <div class="company-details">📞 {{ $hospital_phone }} &nbsp;|&nbsp; ✉ {{ $hospital_email }}</div>
            </div>
        </div>
        <div class="header-right">
            <div class="payslip-title">PAYSLIP</div>
            <div><strong>Month:</strong> {{ Carbon\Carbon::createFromFormat('Y-m', $payroll->month_year)->format('F Y') }}</div>
            <div><strong>Status:</strong> <span class="status-{{ $payroll->status }}">{{ ucfirst($payroll->status) }}</span></div>
            @if($payroll->payment_date)
                <div><strong>Paid on:</strong> {{ $payroll->payment_date->format('d M Y') }}</div>
            @endif
            @if($payroll->transaction_id)
                <div><strong>Txn ID:</strong> {{ $payroll->transaction_id }}</div>
            @endif
        </div>
    </div>

    <div class="details">
        <table>
            <tr>
                <td width="60%">
                    <strong>Employee:</strong> <strong>{{ $payroll->employee->full_name }}</strong><br>
                    <strong>ID:</strong> {{ $payroll->employee->employee_id ?? 'N/A' }}<br>
                    <strong>Type:</strong> {{ class_basename($payroll->employee_type) }}<br>
                    @if(isset($payroll->employee->designation))
                        <strong>Designation:</strong> {{ $payroll->employee->designation ?? 'N/A' }}
                    @endif
                    @if(isset($payroll->employee->specialization))
                        <strong>Specialization:</strong> {{ $payroll->employee->specialization ?? 'N/A' }}
                    @endif
                </td>
                <td width="40%" align="right">
                    <strong>Salary Structure:</strong> {{ $payroll->salaryStructure->payment_frequency ?? 'N/A' }}<br>
                    <strong>Base Salary:</strong> &#8377;{{ number_format($payroll->salaryStructure->base_salary ?? 0, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Earnings &amp; Deductions</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th style="width:45%;">Description</th>
                <th style="width:20%;">Type</th>
                <th style="width:30%;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payroll->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->label }}</td>
                    <td>
                        <span style="color:{{ $item->type == 'earning' ? '#27ae60' : '#e74c3c' }};">
                            {{ ucfirst($item->type) }}
                        </span>
                    </td>
                    <td>
                        @if($item->type == 'earning')
                            + &#8377;{{ number_format($item->amount, 2) }}
                        @else
                            - &#8377;{{ number_format($item->amount, 2) }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">No items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="summary-box">
        <table>
            <tr>
                <td width="33%"><strong>Total Earnings:</strong> &#8377;{{ number_format($payroll->total_earnings, 2) }}</td>
                <td width="33%"><strong>Total Deductions:</strong> -&#8377;{{ number_format($payroll->total_deductions, 2) }}</td>
                <td width="34%" style="text-align:right; font-size:14px;">
                    <strong>Net Payable:</strong> <span class="grand-total">&#8377;{{ number_format($payroll->net_payable, 2) }}</span>
                </td>
            </tr>
        </table>
    </div>
    @if($payroll->notes)
        <div style="margin-top:10px; font-size:11px; background:#f9f9f9; padding:8px 12px; border-left:3px solid #2c3e50;">
            <strong>Notes:</strong><br>
            {{ $payroll->notes }}
        </div>
    @endif
    <div class="footer">
        <p>This is a computer-generated payslip. Please contact HR for any discrepancies.</p>
        <p>Generated on: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

</body>
</html>