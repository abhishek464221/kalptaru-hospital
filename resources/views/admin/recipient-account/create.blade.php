@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Recipient Account</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.recipient-accounts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recipient Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="recipient_type" id="recipient_type" required>
                                    <option value="">Select Type</option>
                                    <option value="doctor" {{ old('recipient_type') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value="employee" {{ old('recipient_type') == 'employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                                @error('recipient_type')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recipient <span class="text-danger">*</span></label>
                                <select class="form-control" name="recipient_id" id="recipient_id" required>
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
                                <input class="form-control" type="text" name="account_holder_name" value="{{ old('account_holder_name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input class="form-control" type="text" name="bank_name" value="{{ old('bank_name') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input class="form-control" type="text" name="account_number" value="{{ old('account_number') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>IFSC Code</label>
                                <input class="form-control" type="text" name="ifsc_code" value="{{ old('ifsc_code') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>UPI ID</label>
                                <input class="form-control" type="text" name="upi_id" value="{{ old('upi_id') }}" placeholder="recipient@bank">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>QR Code Image</label>
                                <input class="form-control" type="file" name="qr_code" accept="image/*">
                                <small class="text-muted">Recommended: 300x300px</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Display Order</label>
                                <input class="form-control" type="number" name="display_order" value="{{ old('display_order', 0) }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="display-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Recipient Account</button>
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
    $(document).ready(function() {
        // Load recipients based on type
        $('#recipient_type').on('change', function() {
            let type = $(this).val();
            let $select = $('#recipient_id');
            $select.html('<option value="">Loading...</option>');
            if (type) {
                $.get('{{ route("admin.recipient-accounts.get-recipients") }}', { type: type }, function(data) {
                    $select.html('<option value="">Select Recipient</option>');
                    $.each(data, function(i, item) {
                        $select.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                });
            } else {
                $select.html('<option value="">Select Recipient</option>');
            }
        });

        // Trigger on page load if type is preselected
        let initialType = $('#recipient_type').val();
        if (initialType) {
            $('#recipient_type').trigger('change');
        }
    });
</script>
@endpush