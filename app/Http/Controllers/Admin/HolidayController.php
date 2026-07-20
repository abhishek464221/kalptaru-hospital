<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $holidays = Holiday::search(
                $request->search,
                [
                    'name',
                    'holiday_date',
                    'description'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.holiday.index', compact('holidays'));
    }

    public function create()
    {
        return view('admin.holiday.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'holiday_date' => 'required|date|unique:holidays,holiday_date',
            'description' => 'nullable|string',
            'is_weekly_off' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['is_weekly_off'] = $request->has('is_weekly_off') ? 1 : 0;

        Holiday::create($data);

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday created successfully.');
    }

    public function edit(Holiday $holiday)
    {
        return view('admin.holiday.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'holiday_date' => 'required|date|unique:holidays,holiday_date,' . $holiday->id,
            'description' => 'nullable|string',
            'is_weekly_off' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['is_weekly_off'] = $request->has('is_weekly_off') ? 1 : 0;

        $holiday->update($data);

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday updated successfully.');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday deleted successfully.');
    }
}