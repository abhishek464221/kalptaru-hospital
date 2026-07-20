@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Payment Gateway</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.payment-gateways.update', $paymentGateway) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gateway Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" 
                                       value="{{ old('name', $paymentGateway->name) }}" required>
                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="qr" {{ old('type', $paymentGateway->type) == 'qr' ? 'selected' : '' }}>QR Code (UPI)</option>
                                    <option value="gateway" {{ old('type', $paymentGateway->type) == 'gateway' ? 'selected' : '' }}>Payment Gateway</option>
                                    <option value="bank" {{ old('type', $paymentGateway->type) == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mode <span class="text-danger">*</span></label>
                                <select class="form-control" name="mode" required>
                                    <option value="test" {{ old('mode', $paymentGateway->mode) == 'test' ? 'selected' : '' }}>Test (Sandbox)</option>
                                    <option value="live" {{ old('mode', $paymentGateway->mode) == 'live' ? 'selected' : '' }}>Live (Production)</option>
                                </select>
                                @error('mode')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Display Order</label>
                                <input class="form-control" type="number" name="display_order" 
                                       value="{{ old('display_order', $paymentGateway->display_order) }}" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>API Key (Encrypted)</label>
                                <input class="form-control" type="text" name="key" 
                                       value="{{ old('key', $paymentGateway->key) }}">
                                <small class="text-muted">Leave blank to keep existing key</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>API Secret (Encrypted)</label>
                                <input class="form-control" type="text" name="secret" 
                                       value="{{ old('secret', $paymentGateway->secret) }}">
                                <small class="text-muted">Leave blank to keep existing secret</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>UPI ID</label>
                                <input class="form-control" type="text" name="upi_id" 
                                       value="{{ old('upi_id', $paymentGateway->upi_id) }}" placeholder="hospital@bank">
                                @error('upi_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>QR Code Image</label>
                                <input class="form-control" type="file" name="qr_code" accept="image/*">
                                @if($paymentGateway->qr_code)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $paymentGateway->qr_code) }}" 
                                             width="100" height="100" class="img-thumbnail">
                                        <p class="text-muted">Current QR Code (Upload new to replace)</p>
                                    </div>
                                @endif
                                <small class="text-muted">Recommended size: 300x300px</small>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">Bank Account Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account Holder Name</label>
                                        <input class="form-control" type="text" name="account_holder" 
                                               value="{{ old('account_holder', $paymentGateway->account_holder) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account Number</label>
                                        <input class="form-control" type="text" name="account_number" 
                                               value="{{ old('account_number', $paymentGateway->account_number) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        <input class="form-control" type="text" name="ifsc_code" 
                                               value="{{ old('ifsc_code', $paymentGateway->ifsc_code) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <input class="form-control" type="text" name="bank_name" 
                                               value="{{ old('bank_name', $paymentGateway->bank_name) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ old('is_active', $paymentGateway->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Gateway</button>
                        <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection