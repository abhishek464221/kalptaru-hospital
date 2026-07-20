@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Bill #{{ $bill->bill_number }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.bills.update', $bill) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="patient_id" required>
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" 
                                            {{ old('patient_id', $bill->patient_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->full_name }} ({{ $patient->patient_id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Appointment (Optional)</label>
                                <select class="form-control" name="appointment_id">
                                    <option value="">Select Appointment</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bill Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="bill_date" 
                                       value="{{ old('bill_date', $bill->bill_date->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Due Date</label>
                                <input type="date" class="form-control" name="due_date" 
                                       value="{{ old('due_date', $bill->due_date ? $bill->due_date->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Bill Items -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Bill Items</h4>
                            <button type="button" class="btn btn-sm btn-primary float-right" id="addItem">
                                <i class="fa fa-plus"></i> Add Item
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody">
                                    @foreach($bill->items as $index => $item)
                                        <tr class="item-row">
                                            <td>
                                                <input type="text" class="form-control" 
                                                       name="items[{{ $index }}][item_name]" 
                                                       value="{{ old('items.'.$index.'.item_name', $item->item_name) }}" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" 
                                                       name="items[{{ $index }}][description]" 
                                                       value="{{ old('items.'.$index.'.description', $item->description) }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control item-qty" 
                                                       name="items[{{ $index }}][quantity]" 
                                                       value="{{ old('items.'.$index.'.quantity', $item->quantity) }}" 
                                                       min="1" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control item-price" 
                                                       name="items[{{ $index }}][unit_price]" 
                                                       value="{{ old('items.'.$index.'.unit_price', $item->unit_price) }}" 
                                                       step="0.01" min="0" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control item-total" 
                                                       value="{{ number_format($item->total, 2) }}" readonly>
                                            </td>
                                            <td>
                                                <select class="form-control" name="items[{{ $index }}][category]">
                                                    <option value="">Select</option>
                                                    <option value="consultation" {{ old('items.'.$index.'.category', $item->category) == 'consultation' ? 'selected' : '' }}>Consultation</option>
                                                    <option value="medicine" {{ old('items.'.$index.'.category', $item->category) == 'medicine' ? 'selected' : '' }}>Medicine</option>
                                                    <option value="lab" {{ old('items.'.$index.'.category', $item->category) == 'lab' ? 'selected' : '' }}>Lab Test</option>
                                                    <option value="room" {{ old('items.'.$index.'.category', $item->category) == 'room' ? 'selected' : '' }}>Room Rent</option>
                                                    <option value="operation" {{ old('items.'.$index.'.category', $item->category) == 'operation' ? 'selected' : '' }}>Operation</option>
                                                    <option value="other" {{ old('items.'.$index.'.category', $item->category) == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger remove-item">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Total Amount:</th>
                                        <th id="totalAmount">{{ number_format($bill->total_amount, 2) }}</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Charges Summary -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Consultation Fee</label>
                                <input type="number" class="form-control charge-field" name="consultation_fee" 
                                       step="0.01" min="0" value="{{ old('consultation_fee', $bill->consultation_fee) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Room Charges</label>
                                <input type="number" class="form-control charge-field" name="room_charges" 
                                       step="0.01" min="0" value="{{ old('room_charges', $bill->room_charges) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Medicine Charges</label>
                                <input type="number" class="form-control charge-field" name="medicine_charges" 
                                       step="0.01" min="0" value="{{ old('medicine_charges', $bill->medicine_charges) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lab Charges</label>
                                <input type="number" class="form-control charge-field" name="lab_charges" 
                                       step="0.01" min="0" value="{{ old('lab_charges', $bill->lab_charges) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Operation Charges</label>
                                <input type="number" class="form-control charge-field" name="operation_charges" 
                                       step="0.01" min="0" value="{{ old('operation_charges', $bill->operation_charges) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Other Charges</label>
                                <input type="number" class="form-control charge-field" name="other_charges" 
                                       step="0.01" min="0" value="{{ old('other_charges', $bill->other_charges) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Discount</label>
                                <input type="number" class="form-control" name="discount" id="discount" 
                                       step="0.01" min="0" value="{{ old('discount', $bill->discount) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tax (%)</label>
                                <input type="number" class="form-control" name="tax" id="tax" 
                                       step="0.01" min="0" value="{{ old('tax', $bill->tax) }}">
                                <small class="text-muted">Enter percentage (e.g., 7 for 7%)</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" rows="3">{{ old('notes', $bill->notes) }}</textarea>
                    </div>

                    <div class="m-t-20 text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Update Bill</button>
                        <a href="{{ route('admin.bills.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let itemIndex = {{ $bill->items->count() }};

    // Add Item Row
    $('#addItem').click(function() {
        let html = `
            <tr class="item-row">
                <td><input type="text" class="form-control" name="items[${itemIndex}][item_name]" required></td>
                <td><input type="text" class="form-control" name="items[${itemIndex}][description]"></td>
                <td><input type="number" class="form-control item-qty" name="items[${itemIndex}][quantity]" value="1" min="1" required></td>
                <td><input type="number" class="form-control item-price" name="items[${itemIndex}][unit_price]" step="0.01" min="0" required></td>
                <td><input type="text" class="form-control item-total" readonly></td>
                <td>
                    <select class="form-control" name="items[${itemIndex}][category]">
                        <option value="">Select</option>
                        <option value="consultation">Consultation</option>
                        <option value="medicine">Medicine</option>
                        <option value="lab">Lab Test</option>
                        <option value="room">Room Rent</option>
                        <option value="operation">Operation</option>
                        <option value="other">Other</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-item">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#itemsBody').append(html);
        itemIndex++;
    });

    // Remove Item
    $(document).on('click', '.remove-item', function() {
        if ($('.item-row').length > 1) {
            $(this).closest('tr').remove();
            calculateTotal();
        }
    });

    // Calculate Item Total
    $(document).on('keyup', '.item-qty, .item-price', function() {
        let row = $(this).closest('tr');
        let qty = parseFloat(row.find('.item-qty').val()) || 0;
        let price = parseFloat(row.find('.item-price').val()) || 0;
        let total = qty * price;
        row.find('.item-total').val(total.toFixed(2));
        calculateTotal();
    });

    // Calculate Grand Total
    function calculateTotal() {
        let total = 0;
        $('.item-total').each(function() {
            let val = parseFloat($(this).val()) || 0;
            total += val;
        });
        $('#totalAmount').text(total.toFixed(2));
    }

    // Calculate charges
    $(document).on('keyup', '.charge-field', function() {
        calculateTotalWithCharges();
    });

    function calculateTotalWithCharges() {
        let total = 0;
        $('.charge-field').each(function() {
            let val = parseFloat($(this).val()) || 0;
            total += val;
        });
        
        let itemTotal = 0;
        $('.item-total').each(function() {
            let val = parseFloat($(this).val()) || 0;
            itemTotal += val;
        });
        
        let finalTotal = total + itemTotal;
        let discount = parseFloat($('#discount').val()) || 0;
        let taxPercent = parseFloat($('#tax').val()) || 0;
        let taxAmount = (finalTotal * taxPercent) / 100;
        let netTotal = finalTotal - discount + taxAmount;
        
        $('#totalAmount').text(netTotal.toFixed(2));
    }

    // Initial calculation
    calculateTotal();
    calculateTotalWithCharges();
</script>
@endpush