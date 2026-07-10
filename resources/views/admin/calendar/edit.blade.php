@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Event</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.calendars.update', $calendar) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Event Title <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="title" value="{{ old('title', $calendar->title) }}" required>
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="start_date" value="{{ old('start_date', $calendar->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input class="form-control" type="date" name="end_date" value="{{ old('end_date', $calendar->end_date ? $calendar->end_date->format('Y-m-d') : '') }}">
                                @error('end_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Time</label>
                                <input class="form-control" type="time" name="start_time" value="{{ old('start_time', $calendar->start_time ? $calendar->start_time->format('H:i') : '') }}" {{ $calendar->is_all_day ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Time</label>
                                <input class="form-control" type="time" name="end_time" value="{{ old('end_time', $calendar->end_time ? $calendar->end_time->format('H:i') : '') }}" {{ $calendar->is_all_day ? 'disabled' : '' }}>
                                @error('end_time')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="padding-top: 28px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_all_day" id="is_all_day" value="1" {{ old('is_all_day', $calendar->is_all_day) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_all_day">All Day Event</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Color</label>
                                <select class="form-control" name="color">
                                    <option value="">Select Color</option>
                                    <option value="#FF0000" {{ old('color', $calendar->color) == '#FF0000' ? 'selected' : '' }}>Red</option>
                                    <option value="#00FF00" {{ old('color', $calendar->color) == '#00FF00' ? 'selected' : '' }}>Green</option>
                                    <option value="#0000FF" {{ old('color', $calendar->color) == '#0000FF' ? 'selected' : '' }}>Blue</option>
                                    <option value="#FFFF00" {{ old('color', $calendar->color) == '#FFFF00' ? 'selected' : '' }}>Yellow</option>
                                    <option value="#FF00FF" {{ old('color', $calendar->color) == '#FF00FF' ? 'selected' : '' }}>Pink</option>
                                    <option value="#00FFFF" {{ old('color', $calendar->color) == '#00FFFF' ? 'selected' : '' }}>Cyan</option>
                                    <option value="#FFA500" {{ old('color', $calendar->color) == '#FFA500' ? 'selected' : '' }}>Orange</option>
                                    <option value="#800080" {{ old('color', $calendar->color) == '#800080' ? 'selected' : '' }}>Purple</option>
                                    <option value="#808080" {{ old('color', $calendar->color) == '#808080' ? 'selected' : '' }}>Gray</option>
                                    <option value="#000000" {{ old('color', $calendar->color) == '#000000' ? 'selected' : '' }}>Black</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Location</label>
                                <input class="form-control" type="text" name="location" value="{{ old('location', $calendar->location) }}" placeholder="e.g. Conference Room A">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="4">{{ old('description', $calendar->description) }}</textarea>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Event</button>
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
        $('#is_all_day').on('change', function() {
            if ($(this).is(':checked')) {
                $('input[name="start_time"]').val('').prop('disabled', true);
                $('input[name="end_time"]').val('').prop('disabled', true);
            } else {
                $('input[name="start_time"]').prop('disabled', false);
                $('input[name="end_time"]').prop('disabled', false);
            }
        });
    });
</script>
@endpush