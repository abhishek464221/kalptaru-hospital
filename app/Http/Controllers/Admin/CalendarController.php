<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display a listing of calendar events.
     */
    public function index()
    {
        $events = Calendar::with('user')->orderBy('start_date', 'asc')->get();
        return view('admin.calendar.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.calendar.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'color' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'is_all_day' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['is_all_day'] = $request->has('is_all_day') ? 1 : 0;

        // If end_date is not set, use start_date
        if (empty($data['end_date'])) {
            $data['end_date'] = $data['start_date'];
        }

        Calendar::create($data);

        return redirect()->route('admin.calendars.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Calendar $calendar)
    {
        return view('admin.calendar.edit', compact('calendar'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Calendar $calendar)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'color' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'is_all_day' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['is_all_day'] = $request->has('is_all_day') ? 1 : 0;

        // If end_date is not set, use start_date
        if (empty($data['end_date'])) {
            $data['end_date'] = $data['start_date'];
        }

        $calendar->update($data);

        return redirect()->route('admin.calendars.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Calendar $calendar)
    {
        $calendar->delete();
        return redirect()->route('admin.calendars.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Get events for JSON (for calendar view).
     */
    public function getEvents(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $events = Calendar::where(function ($query) use ($start, $end) {
            $query->whereBetween('start_date', [$start, $end])
                ->orWhereBetween('end_date', [$start, $end])
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_date', '<=', $start)
                        ->where('end_date', '>=', $end);
                });
        })->get();

        return response()->json($events);
    }
}