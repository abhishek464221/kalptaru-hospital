@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="page-title">Payroll Management</h4>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <form action="{{ route('admin.payrolls.generate') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-refresh"></i> Generate Payroll
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Type</th>
                                        <th>Month</th>
                                        <th>Total Earnings</th>
                                        <th>Deductions</th>
                                        <th>Net Payable</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payrolls as $key => $payroll)
                                        <tr>
                                            <td>
                                                @if($payroll->status == 'approved')
                                                    <input type="checkbox" class="payroll-check" value="{{ $payroll->id }}">
                                                @endif
                                            </td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <strong>{{ $payroll->employee_name }}</strong>
                                            </td>
                                            <td>{{ class_basename($payroll->employee_type) }}</td>
                                            <td>{{ Carbon\Carbon::createFromFormat('Y-m', $payroll->month_year)->format('M Y') }}</td>
                                            <td>₹{{ number_format($payroll->total_earnings, 2) }}</td>
                                            <td>₹{{ number_format($payroll->total_deductions, 2) }}</td>
                                            <td>
                                                <strong>₹{{ number_format($payroll->net_payable, 2) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $payroll->status == 'paid' ? 'success' : ($payroll->status == 'approved' ? 'info' : 'warning') }}">
                                                    {{ ucfirst($payroll->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.payrolls.show', $payroll) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payrolls.payslip', $payroll) }}" class="btn btn-sm btn-primary" target="_blank">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                @if($payroll->status == 'draft')
                                                    <form action="{{ route('admin.payrolls.approve', $payroll) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($payroll->status == 'approved')
                                                    <button class="btn btn-sm btn-primary mark-paid-btn" data-id="{{ $payroll->id }}">
                                                        <i class="fa fa-credit-card"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No payroll records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($payrolls->where('status', 'approved')->count() > 0)
                            <div class="mt-3">
                                <button class="btn btn-primary" id="bulkPayBtn">
                                    <i class="fa fa-money"></i> Bulk Pay Selected
                                </button>
                            </div>
                        @endif

                        <div class="mt-3">
                            {{ $payrolls->links() }}
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
                        <input type="text" class="form-control" name="transaction_id">
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
    // Select All
    $('#selectAll').on('change', function() {
        $('.payroll-check').prop('checked', this.checked);
    });

    // Bulk Pay
    $('#bulkPayBtn').on('click', function() {
        let ids = [];
        $('.payroll-check:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            alert('Please select at least one payroll.');
            return;
        }

        if (confirm('Are you sure you want to mark selected payrolls as paid?')) {
            $.ajax({
                url: '{{ route("admin.payrolls.bulk-pay") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    payroll_ids: ids
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error processing payment.');
                }
            });
        }
    });

    // Mark Single Paid
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