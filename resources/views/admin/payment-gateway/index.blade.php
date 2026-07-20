@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="page-title">Payment Gateways</h4>
                    <a href="{{ route('admin.payment-gateways.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Gateway
                    </a>
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
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Mode</th>
                                        <th>UPI ID / Account</th>
                                        <th>QR Code</th>
                                        <th>Status</th>
                                        <th>Order</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gateways as $key => $gateway)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><strong>{{ $gateway->name }}</strong></td>
                                            <td>
                                                <span class="badge badge-{{ $gateway->type == 'qr' ? 'primary' : ($gateway->type == 'gateway' ? 'success' : 'info') }}">
                                                    {{ ucfirst($gateway->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $gateway->mode == 'live' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($gateway->mode) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($gateway->type == 'qr')
                                                    {{ $gateway->upi_id ?? 'N/A' }}
                                                @else
                                                    {{ $gateway->account_number ?? 'N/A' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($gateway->qr_code)
                                                    <img src="{{ asset('storage/' . $gateway->qr_code) }}" 
                                                         width="50" height="50" class="rounded">
                                                @else
                                                    <span class="text-muted">No QR</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" 
                                                           class="custom-control-input toggle-status" 
                                                           id="status_{{ $gateway->id }}"
                                                           data-id="{{ $gateway->id }}"
                                                           {{ $gateway->is_active ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status_{{ $gateway->id }}">
                                                        <span class="badge badge-{{ $gateway->is_active ? 'success' : 'secondary' }}">
                                                            {{ $gateway->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{ $gateway->display_order }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.payment-gateways.edit', $gateway) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" 
                                                   data-toggle="modal" 
                                                   data-target="#delete_gateway_{{ $gateway->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div id="delete_gateway_{{ $gateway->id }}" class="modal fade delete-modal">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <h3>Are you sure want to delete this Gateway?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.payment-gateways.destroy', $gateway) }}" 
                                                                  method="POST" style="display:inline;">
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
                                            <td colspan="9" class="text-center">No payment gateways found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $gateways->links() }}
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
    // Toggle Status
    $('.toggle-status').on('change', function() {
        let id = $(this).data('id');
        let checkbox = $(this);
        let label = checkbox.closest('.custom-control').find('.badge');

        $.ajax({
            url: '/admin/payment-gateways/' + id + '/toggle',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    if (response.status == 'active') {
                        label.removeClass('badge-secondary').addClass('badge-success').text('Active');
                    } else {
                        label.removeClass('badge-success').addClass('badge-secondary').text('Inactive');
                    }
                }
            },
            error: function() {
                alert('Error toggling status.');
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
        });
    });
</script>
@endpush