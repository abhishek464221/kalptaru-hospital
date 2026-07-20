@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Recipient Account</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.recipient-accounts.update', $recipientAccount) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recipient Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="recipient_type" id="edit_recipient_type" required>
                                    <option value="">Select Type</option>
                                    <option value="doctor" {{ old('recipient_type', $currentTypeLower) == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value="employee" {{ old('recipient_type', $currentTypeLower) == 'employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                                @error('recipient_type')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recipient <span class="text-danger">*</span></label>
                                <select class="form-control" name="recipient_id" id="edit_recipient_id" required>
                                    <option value="">Select Recipient</option>
                                </select>
                                @error('recipient_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Holder Name</label>
                                <input class="form-control" type="text" name="account_holder_name" value="{{ old('account_holder_name', $recipientAccount->account_holder_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input class="form-control" type="text" name="bank_name" value="{{ old('bank_name', $recipientAccount->bank_name) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input class="form-control" type="text" name="account_number" value="{{ old('account_number', $recipientAccount->account_number) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>IFSC Code</label>
                                <input class="form-control" type="text" name="ifsc_code" value="{{ old('ifsc_code', $recipientAccount->ifsc_code) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>UPI ID</label>
                                <input class="form-control" type="text" name="upi_id" value="{{ old('upi_id', $recipientAccount->upi_id) }}" placeholder="recipient@bank">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>QR Code Image</label>
                                <input class="form-control" type="file" name="qr_code" accept="image/*">
                                @if($recipientAccount->qr_code)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $recipientAccount->qr_code) }}" width="80" height="80" class="img-thumbnail">
                                        <p class="text-muted">Current QR Code (upload new to replace)</p>
                                    </div>
                                @endif
                                <small class="text-muted">Recommended: 300x300px</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Display Order</label>
                                <input class="form-control" type="number" name="display_order" value="{{ old('display_order', $recipientAccount->display_order) }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="display-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $recipientAccount->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Recipient Account</button>
                        <a href="{{ route('admin.recipient-accounts.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function loadRecipientsForEdit(selectedId = null) {
        let type = $('#edit_recipient_type').val();
        let $select = $('#edit_recipient_id');
        $select.html('<option value="">Loading...</option>');
        if (type) {
            $.get('{{ route("admin.recipient-accounts.get-recipients") }}', { type: type }, function(data) {
                $select.html('<option value="">Select Recipient</option>');
                $.each(data, function(i, item) {
                    let sel = (selectedId && selectedId == item.id) ? 'selected' : '';
                    $select.append('<option value="' + item.id + '" ' + sel + '>' + item.name + '</option>');
                });
            });
        } else {
            $select.html('<option value="">Select Recipient</option>');
        }
    }

    $(document).ready(function() {
        let currentSelected = {{ $recipientAccount->recipientable_id }};
        loadRecipientsForEdit(currentSelected);

        $('#edit_recipient_type').on('change', function() {
            loadRecipientsForEdit();
        });
    });
</script>
@endpush