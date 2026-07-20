@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Payroll Details</h4>
                        <div class="float-right">
                            <span class="badge badge-{{ $payroll->status == 'paid' ? 'success' : ($payroll->status == 'approved' ? 'info' : 'warning') }}">
                                {{ ucfirst($payroll->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Employee:</strong> {{ $payroll->employee->full_name }}</p>
                                <p><strong>Employee ID:</strong> {{ $payroll->employee->employee_id ?? $payroll->employee->doctor_id ?? 'N/A' }}</p>
                                <p><strong>Type:</strong> {{ class_basename($payroll->employee_type) }}</p>
                                <p><strong>Month:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m', $payroll->month_year)->format('F Y') }}</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p><strong>Total Earnings:</strong> ₹{{ number_format($payroll->total_earnings, 2) }}</p>
                                <p><strong>Total Deductions:</strong> -₹{{ number_format($payroll->total_deductions, 2) }}</p>
                                <h4><strong>Net Payable:</strong> ₹{{ number_format($payroll->net_payable, 2) }}</h4>
                                @if($payroll->status == 'paid')
                                    <p><strong>Payment Date:</strong> {{ $payroll->payment_date ? $payroll->payment_date->format('d M Y') : 'N/A' }}</p>
                                    <p><strong>Transaction ID:</strong> {{ $payroll->transaction_id ?? 'N/A' }}</p>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <!-- Salary Breakdown -->
                        <h5>Salary Breakdown</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Label</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payroll->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->label }}</td>
                                        <td><span class="badge badge-{{ $item->type == 'earning' ? 'success' : 'danger' }}">{{ ucfirst($item->type) }}</span></td>
                                        <td>₹{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- ============================================================ -->
                        <!-- Recipient Account Details (New Block)                         -->
                        <!-- ============================================================ -->
                        @php
                            $recipient = $payroll->employee->active_recipient_account ?? null;
                        @endphp

                        @if($recipient)
                            <div class="card mt-3" style="border-left: 4px solid #2c3e50;">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="fa fa-credit-card"></i> Recipient Account Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($recipient->account_holder_name)
                                                <p><strong>Account Holder:</strong> {{ $recipient->account_holder_name }}</p>
                                            @endif
                                            @if($recipient->bank_name)
                                                <p><strong>Bank:</strong> {{ $recipient->bank_name }}</p>
                                            @endif
                                            @if($recipient->account_number)
                                                <p><strong>Account Number:</strong> {{ $recipient->account_number }}</p>
                                            @endif
                                            @if($recipient->ifsc_code)
                                                <p><strong>IFSC:</strong> {{ $recipient->ifsc_code }}</p>
                                            @endif
                                            @if($recipient->upi_id)
                                                <p><strong>UPI ID:</strong> {{ $recipient->upi_id }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-center">
                                            @if($recipient->qr_code)
                                                <div>
                                                    <img src="{{ asset('storage/' . $recipient->qr_code) }}" 
                                                         alt="QR Code" 
                                                         class="img-fluid" 
                                                         style="max-width: 150px; border: 1px solid #ddd; padding: 5px;">
                                                    <p class="text-muted mt-1">Scan to Pay</p>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i> No QR Code uploaded.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">Use the above details to make the payment, then mark as paid.</small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning mt-3">
                                <i class="fa fa-exclamation-triangle"></i> 
                                No recipient account found for this employee. 
                                <a href="{{ route('admin.recipient-accounts.create') }}?type={{ class_basename($payroll->employee_type) }}&id={{ $payroll->employee_id }}" class="alert-link">
                                    Add recipient account
                                </a>
                            </div>
                        @endif
                        <!-- ============================================================ -->

                        <div class="mt-4">
                            @if($payroll->status == 'draft')
                                <form action="{{ route('admin.payrolls.approve', $payroll) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                            @endif

                            @if($payroll->status == 'approved')
                                <button class="btn btn-primary mark-paid-btn" data-id="{{ $payroll->id }}">
                                    <i class="fa fa-credit-card"></i> Mark as Paid
                                </button>
                            @endif

                            <a href="{{ route('admin.payrolls.payslip', $payroll) }}" class="btn btn-info" target="_blank">
                                <i class="fa fa-file-pdf-o"></i> Download Payslip
                            </a>
                            <a href="{{ route('admin.payrolls.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mark Paid Modal -->
<div class="modal fade" id="markPaidModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mark as Paid</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="markPaidForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="payroll_id" id="markPaidId">
                    <div class="form-group">
                        <label>Transaction ID (Optional)</label>
                        <input type="text" class="form-control" name="transaction_id" placeholder="e.g., UPI ref no.">
                    </div>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> After confirming payment via recipient account, enter transaction ID if available.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Mark as Paid</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Mark as Paid - Single
    $('.mark-paid-btn').on('click', function() {
        let id = $(this).data('id');
        $('#markPaidId').val(id);
        $('#markPaidModal').modal('show');
    });

    $('#markPaidForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#markPaidId').val();
        let transactionId = $('input[name="transaction_id"]').val();

        $.ajax({
            url: '/admin/payrolls/' + id + '/paid',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                transaction_id: transactionId
            },
            success: function(response) {
                location.reload();
            },
            error: function() {
                alert('Error marking as paid.');
            }
        });
    });
</script>
@endpush