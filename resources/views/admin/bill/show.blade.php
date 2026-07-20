@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Bill #{{ $bill->bill_number }}</h4>
                        <div class="float-right">
                            <span class="badge badge-{{ $bill->payment_status == 'paid' ? 'success' : ($bill->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($bill->payment_status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Patient:</strong> {{ $bill->patient->full_name }}</p>
                                <p><strong>Patient ID:</strong> {{ $bill->patient->patient_id }}</p>
                                <p><strong>Bill Date:</strong> {{ $bill->bill_date->format('d M Y') }}</p>
                                <p><strong>Due Date:</strong> {{ $bill->due_date ? $bill->due_date->format('d M Y') : 'N/A' }}</p>
                                <p><strong>Payment Method:</strong> {{ $bill->payment_method ? ucfirst(str_replace('_', ' ', $bill->payment_method)) : 'N/A' }}</p>
                                @if($bill->transaction_id)
                                    <p><strong>Transaction ID:</strong> {{ $bill->transaction_id }}</p>
                                @endif
                            </div>
                            <div class="col-md-6 text-right">
                                <p><strong>Total Amount:</strong> ₹{{ number_format($bill->total_amount, 2) }}</p>
                                @if($bill->discount > 0)
                                    <p><strong>Discount:</strong> -₹{{ number_format($bill->discount, 2) }}</p>
                                @endif
                                @if($bill->tax > 0)
                                    <p><strong>Tax ({{ $bill->tax }}%):</strong> +₹{{ number_format(($bill->total_amount * $bill->tax) / 100, 2) }}</p>
                                @endif
                                <h4><strong>Net Amount:</strong> ₹{{ number_format($bill->net_amount, 2) }}</h4>
                            </div>
                        </div>

                        <hr>

                        <h5>Bill Items</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bill->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->description ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                        <td>₹{{ number_format($item->total, 2) }}</td>
                                        <td>{{ ucfirst($item->category ?? 'N/A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No items found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Charges Breakdown -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Charges Breakdown</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Consultation Fee</th>
                                        <th>Room Charges</th>
                                        <th>Medicine Charges</th>
                                        <th>Lab Charges</th>
                                        <th>Operation Charges</th>
                                        <th>Other Charges</th>
                                    </tr>
                                    <tr>
                                        <td>₹{{ number_format($bill->consultation_fee, 2) }}</td>
                                        <td>₹{{ number_format($bill->room_charges, 2) }}</td>
                                        <td>₹{{ number_format($bill->medicine_charges, 2) }}</td>
                                        <td>₹{{ number_format($bill->lab_charges, 2) }}</td>
                                        <td>₹{{ number_format($bill->operation_charges, 2) }}</td>
                                        <td>₹{{ number_format($bill->other_charges, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($bill->notes)
                            <div class="mt-3">
                                <strong>Notes:</strong>
                                <p>{{ $bill->notes }}</p>
                            </div>
                        @endif

                        @if($bill->payment_status == 'pending')
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-success btn-lg" id="payNowBtn">
                                    <i class="fa fa-qrcode"></i> Pay Now
                                </button>
                            </div>

                            <!-- QR Code Modal -->
                            <div class="modal fade" id="qrModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pay with QR Code</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div id="qrLoader">
                                                <div class="spinner-border text-primary"></div>
                                                <p>Loading...</p>
                                            </div>
                                            <div id="qrContent" style="display:none;">
                                                @if($gateway && $gateway->qr_code)
                                                    <img src="{{ asset('storage/' . $gateway->qr_code) }}" 
                                                         alt="QR Code" 
                                                         class="img-fluid"
                                                         style="max-width: 300px;">
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fa fa-info-circle"></i>
                                                        UPI ID: <strong>{{ $gateway->upi_id ?? 'N/A' }}</strong>
                                                        <br>
                                                        <small>Please scan with any UPI app</small>
                                                    </div>
                                                @endif
                                                
                                                <div class="mt-3">
                                                    <p><strong>Amount:</strong> ₹{{ number_format($bill->net_amount, 2) }}</p>
                                                    <p><strong>Bill Number:</strong> {{ $bill->bill_number }}</p>
                                                    <p><strong>Pay to:</strong> {{ $gateway->account_holder ?? 'Hospital' }}</p>
                                                    <p><strong>Account Details:</strong></p>
                                                    <p>Account: {{ $gateway->account_number ?? 'N/A' }}</p>
                                                    <p>IFSC: {{ $gateway->ifsc_code ?? 'N/A' }}</p>
                                                    <p>Bank: {{ $gateway->bank_name ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <form action="{{ route('admin.bills.payment.verify', $bill) }}" method="POST" id="paymentVerifyForm">
                                                        @csrf
                                                        <input type="hidden" name="amount" value="{{ $bill->net_amount }}">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fa fa-check"></i> I have made the payment
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('admin.bills.invoice', $bill) }}" class="btn btn-primary" target="_blank">
                                <i class="fa fa-file-pdf-o"></i> Download Invoice PDF
                            </a>
                            @if($bill->payment_status == 'pending')
                                <a href="{{ route('admin.bills.edit', $bill) }}" class="btn btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            @endif
                            <a href="{{ route('admin.bills.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#payNowBtn').click(function() {
        $('#qrModal').modal('show');
        $('#qrContent').show();
        $('#qrLoader').hide();
    });

    // Payment verification
    $('#paymentVerifyForm').submit(function(e) {
        e.preventDefault();
        if (confirm('Have you completed the payment via QR Code/UPI?')) {
            this.submit();
        }
    });
</script>
@endpush