@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Medicine</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.medicines.update', $medicine) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Medicine Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" value="{{ old('name', $medicine->name) }}" required>
                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <input class="form-control" type="text" name="category" value="{{ old('category', $medicine->category) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Supplier</label>
                                <input class="form-control" type="text" name="supplier" value="{{ old('supplier', $medicine->supplier) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Batch Number</label>
                                <input class="form-control" type="text" name="batch_number" value="{{ old('batch_number', $medicine->batch_number) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase Price (₹)</label>
                                <input class="form-control" type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $medicine->purchase_price) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Selling Price (₹)</label>
                                <input class="form-control" type="number" step="0.01" name="selling_price" value="{{ old('selling_price', $medicine->selling_price) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock Quantity</label>
                                <input class="form-control" type="number" name="stock_quantity" value="{{ old('stock_quantity', $medicine->stock_quantity) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reorder Level</label>
                                <input class="form-control" type="number" name="reorder_level" value="{{ old('reorder_level', $medicine->reorder_level) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Manufacture Date</label>
                                <input class="form-control" type="date" name="manufacture_date" value="{{ old('manufacture_date', $medicine->manufacture_date ? $medicine->manufacture_date->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input class="form-control" type="date" name="expiry_date" value="{{ old('expiry_date', $medicine->expiry_date ? $medicine->expiry_date->format('Y-m-d') : '') }}">
                                @error('expiry_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description', $medicine->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $medicine->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Medicine</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection