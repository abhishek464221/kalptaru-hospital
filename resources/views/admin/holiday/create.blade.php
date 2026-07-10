@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Holiday</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.holidays.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Holiday Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" name="holiday_date" value="{{ old('holiday_date') }}" required>
                        @error('holiday_date')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Type</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_weekly_off" id="weekly_off" value="1" {{ old('is_weekly_off') ? 'checked' : '' }}>
                            <label class="form-check-label" for="weekly_off">Weekly Off</label>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Holiday</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection