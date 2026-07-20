@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="page-title">Patient Bills</h4>
                    <a href="{{ route('admin.bills.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Create Bill
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" 
                       id="search" 
                       class="form-control" 
                       placeholder="Search by Bill # or Patient..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-control" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="partially_paid" {{ request('status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" id="applyFilter"><i class="fa fa-filter"></i> Filter</button>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{ route('admin.bills.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="table-data">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bill Number</th>
                                            <th>Patient</th>
                                            <th>Date</th>
                                            <th>Due Date</th>
                                            <th>Total</th>
                                            <th>Net Amount</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bills as $key => $bill)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <strong>{{ $bill->bill_number }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $bill->created_at->format('d M Y h:i A') }}</small>
                                                </td>
                                                <td>
                                                    <strong>{{ $bill->patient->full_name ?? 'N/A' }}</strong>
                                                    <br>
                                                    <small>{{ $bill->patient->patient_id ?? 'N/A' }}</small>
                                                </td>
                                                <td>{{ $bill->bill_date->format('d M Y') }}</td>
                                                <td>
                                                    @if($bill->due_date)
                                                        {{ $bill->due_date->format('d M Y') }}
                                                        @if($bill->due_date < now())
                                                            <span class="badge badge-danger">Overdue</span>
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>₹{{ number_format($bill->total_amount, 2) }}</td>
                                                <td>
                                                    <strong>₹{{ number_format($bill->net_amount, 2) }}</strong>
                                                    @if($bill->discount > 0)
                                                        <br>
                                                        <small class="text-success">-₹{{ number_format($bill->discount, 2) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $bill->payment_status == 'paid' ? 'success' : ($bill->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst(str_replace('_', ' ', $bill->payment_status)) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.bills.show', $bill) }}" class="btn btn-sm btn-info" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @if($bill->payment_status == 'pending')
                                                            <a href="{{ route('admin.bills.edit', $bill) }}" class="btn btn-sm btn-primary" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-danger" title="Delete" 
                                                               data-toggle="modal" data-target="#delete_bill_{{ $bill->id }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('admin.bills.invoice', $bill) }}" class="btn btn-sm btn-success" target="_blank" title="Download Invoice">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal -->
                                            <div id="delete_bill_{{ $bill->id }}" class="modal fade delete-modal" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <h3>Are you sure want to delete this Bill?</h3>
                                                            <p><strong>Bill #:</strong> {{ $bill->bill_number }}</p>
                                                            <p><strong>Patient:</strong> {{ $bill->patient->full_name ?? 'N/A' }}</p>
                                                            <p><strong>Amount:</strong> ₹{{ number_format($bill->net_amount, 2) }}</p>
                                                            <div class="m-t-20">
                                                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                                <form action="{{ route('admin.bills.destroy', $bill) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">
                                                    <div class="p-5">
                                                        <i class="fa fa-file-text-o fa-3x text-muted"></i>
                                                        <p class="mt-3">No bills found.</p>
                                                        <a href="{{ route('admin.bills.create') }}" class="btn btn-primary">
                                                            <i class="fa fa-plus"></i> Create First Bill
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="9">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>Total Bills:</strong> {{ $bills->total() }}
                                                        @if($bills->total() > 0)
                                                            <br>
                                                            <small class="text-muted">
                                                                Showing {{ $bills->firstItem() }} to {{ $bills->lastItem() }} of {{ $bills->total() }} entries
                                                            </small>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        {{ $bills->appends(request()->query())->links() }}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
    // Live Search
    let timer;
    $('#search').keyup(function(){
        clearTimeout(timer);
        timer = setTimeout(function(){
            let search = $('#search').val();
            let status = $('#statusFilter').val();
            let url = "{{ route('admin.bills.index') }}";
            if (search || status) {
                url += '?';
                if (search) url += 'search=' + encodeURIComponent(search) + '&';
                if (status) url += 'status=' + encodeURIComponent(status);
            }
            window.location.href = url;
        }, 500);
    });

    // Filter Button
    $('#applyFilter').click(function(){
        let search = $('#search').val();
        let status = $('#statusFilter').val();
        let url = "{{ route('admin.bills.index') }}";
        if (search || status) {
            url += '?';
            if (search) url += 'search=' + encodeURIComponent(search) + '&';
            if (status) url += 'status=' + encodeURIComponent(status);
        }
        window.location.href = url;
    });

    // Enter key on search
    $('#search').keypress(function(e){
        if (e.which == 13) {
            $('#applyFilter').click();
        }
    });

    // Status filter change triggers automatically
    $('#statusFilter').change(function(){
        $('#applyFilter').click();
    });
</script>
@endpush