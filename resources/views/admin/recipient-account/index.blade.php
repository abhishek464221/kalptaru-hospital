@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="page-title">Recipient Accounts</h4>
            <a href="{{ route('admin.recipient-accounts.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Recipient Account
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Recipient</th>
                                <th>Type</th>
                                <th>Account Details</th>
                                <th>UPI / QR</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accounts as $key => $acc)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <strong>{{ $acc->recipientable->full_name ?? 'N/A' }}</strong>
                                        <br>
                                        <small>{{ $acc->recipientable->employee_id ?? $acc->recipientable->doctor_id ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ class_basename($acc->recipientable_type) }}</td>
                                    <td>
                                        @if($acc->account_holder_name) {{ $acc->account_holder_name }}<br> @endif
                                        @if($acc->account_number) A/c: {{ $acc->account_number }}<br> @endif
                                        @if($acc->ifsc_code) IFSC: {{ $acc->ifsc_code }} @endif
                                    </td>
                                    <td>
                                        @if($acc->upi_id) UPI: {{ $acc->upi_id }}<br> @endif
                                        @if($acc->qr_code)
                                            <img src="{{ asset('storage/' . $acc->qr_code) }}" width="40" height="40" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $acc->is_active ? 'success' : 'secondary' }}">
                                            {{ $acc->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $acc->display_order }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.recipient-accounts.edit', $acc) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $acc->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-{{ $acc->is_active ? 'secondary' : 'success' }} toggle-status" 
                                                data-url="{{ route('admin.recipient-accounts.toggle', $acc) }}">
                                            <i class="fa fa-{{ $acc->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $acc->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h3>Delete Recipient Account?</h3>
                                                <p>{{ $acc->recipientable->full_name ?? '' }}</p>
                                                <form action="{{ route('admin.recipient-accounts.destroy', $acc) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger">Delete</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr><td colspan="8" class="text-center">No recipient accounts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $accounts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).on('click', '.toggle-status', function() {
        let url = $(this).data('url'); 
        let btn = $(this);
        $.post(url, {
            _token: '{{ csrf_token() }}'
        }, function(res) {
            if (res.success) {
                location.reload();
            }
        }).fail(function() {
            alert('Error toggling status.');
        });
    });
</script>
@endpush