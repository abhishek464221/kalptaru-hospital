<!DOCTYPE html>
<html>
<head>
    <title>Invoice - {{ $bill->bill_number }}</title>
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
        .header-right .invoice-title {
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
        .charges-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 10px;
        }
        .charges-table th, .charges-table td {
            border: 1px solid #ddd;
            padding: 4px 8px;
            text-align: center;
        }
        .charges-table th {
            background-color: #f8f9fa;
            font-weight: bold;
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
        .status-paid { color: #27ae60; font-weight: bold; }
        .status-pending { color: #f39c12; font-weight: bold; }
        .status-failed { color: #e74c3c; font-weight: bold; }
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
        .notes {
            margin-top: 10px;
            font-size: 11px;
            clear: both;
            background: #f9f9f9;
            padding: 8px 12px;
            border-left: 3px solid #2c3e50;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0 5px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }
    </style>
</head>
<body>

    <div class="watermark">INVOICE</div>

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
            <div class="invoice-title">INVOICE</div>
            <div><strong>Bill #:</strong> {{ $bill->bill_number }}</div>
            <div><strong>Date:</strong> {{ $bill->bill_date->format('d M Y') }}</div>
            <div><strong>Due:</strong> {{ $bill->due_date ? $bill->due_date->format('d M Y') : 'N/A' }}</div>
            <div><strong>Status:</strong> <span class="status-{{ $bill->payment_status }}">{{ ucfirst($bill->payment_status) }}</span></div>
            @if($bill->payment_status == 'paid')
                <div><strong>Paid on:</strong> {{ $bill->updated_at->format('d M Y') }}</div>
                @if($bill->transaction_id)
                    <div><strong>Txn ID:</strong> {{ $bill->transaction_id }}</div>
                @endif
            @endif
        </div>
    </div>

    <div class="details">
        <table>
            <tr>
                <td width="60%">
                    <strong>Bill To:</strong><br>
                    <strong>{{ $bill->patient->full_name }}</strong><br>
                    Patient ID: {{ $bill->patient->patient_id }}<br>
                    @if($bill->patient->email) Email: {{ $bill->patient->email }}<br> @endif
                    @if($bill->patient->phone) Phone: {{ $bill->patient->phone }} @endif
                </td>
                <td width="40%" align="right">
                    @if($bill->payment_method)
                        <strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $bill->payment_method)) }}<br>
                    @endif
                    @if($bill->transaction_id)
                        <strong>Transaction ID:</strong> {{ $bill->transaction_id }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Bill Items</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th style="width:25%;">Item Name</th>
                <th style="width:25%;">Description</th>
                <th style="width:8%;">Qty</th>
                <th style="width:15%;">Unit Price</th>
                <th style="width:12%;">Total</th>
                <th style="width:10%;">Category</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bill->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->description ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>&#8377;{{ number_format($item->unit_price, 2) }}</td>
                    <td>&#8377;{{ number_format($item->total, 2) }}</td>
                    <td>{{ ucfirst($item->category ?? 'N/A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">No items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($bill->consultation_fee > 0 || $bill->room_charges > 0 || $bill->medicine_charges > 0 || $bill->lab_charges > 0 || $bill->operation_charges > 0 || $bill->other_charges > 0)
        <div class="section-title">Charges Breakdown</div>
        <table class="charges-table">
            <tr>
                <th>Consultation</th>
                <th>Room</th>
                <th>Medicine</th>
                <th>Lab</th>
                <th>Operation</th>
                <th>Other</th>
            </tr>
            <tr>
                <td>&#8377;{{ number_format($bill->consultation_fee, 2) }}</td>
                <td>&#8377;{{ number_format($bill->room_charges, 2) }}</td>
                <td>&#8377;{{ number_format($bill->medicine_charges, 2) }}</td>
                <td>&#8377;{{ number_format($bill->lab_charges, 2) }}</td>
                <td>&#8377;{{ number_format($bill->operation_charges, 2) }}</td>
                <td>&#8377;{{ number_format($bill->other_charges, 2) }}</td>
            </tr>
        </table>
    @endif

    <div class="total-section">
        <table>
            <tr>
                <td>Subtotal (Items + Charges):</td>
                <td>&#8377;{{ number_format($bill->total_amount, 2) }}</td>
            </tr>
            @if($bill->discount > 0)
                <tr>
                    <td>Discount:</td>
                    <td>-&#8377;{{ number_format($bill->discount, 2) }}</td>
                </tr>
            @endif
            @if($bill->tax > 0)
                <tr>
                    <td>Tax ({{ $bill->tax }}%):</td>
                    <td>+&#8377;{{ number_format(($bill->total_amount * $bill->tax) / 100, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td style="font-size:14px; font-weight:bold;">Net Amount:</td>
                <td class="grand-total">&#8377;{{ number_format($bill->net_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    @if($bill->notes)
        <div class="notes">
            <strong>Notes:</strong><br>
            {{ $bill->notes }}
        </div>
    @endif

    <div class="footer">
        <p>This is a computer-generated invoice. Thank you for choosing {{ $hospital_name }}.</p>
        <p>Generated on: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

</body>
</html>