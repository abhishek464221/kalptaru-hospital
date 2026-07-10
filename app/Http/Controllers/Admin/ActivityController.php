<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function index(Request $request)
    {
        $query = Activity::with('user');

        // Filter by module
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get unique modules and actions for filters
        $modules = Activity::select('module')->distinct()->whereNotNull('module')->pluck('module');
        $actions = Activity::select('action')->distinct()->pluck('action');

        return view('admin.activity.index', compact('activities', 'modules', 'actions'));
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity log deleted successfully.');
    }

    /**
     * Clear all activities (optional).
     */
    public function clearAll()
    {
        Activity::truncate();
        return redirect()->route('admin.activities.index')
            ->with('success', 'All activity logs cleared successfully.');
    }
}