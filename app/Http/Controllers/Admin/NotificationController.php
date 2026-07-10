<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Events\NotificationSent;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = Notification::with('user')->get();
        return view('admin.notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.notification.create', compact('users'));
    }

    /**
     * Store a newly created notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'nullable|string|max:50',
            'target_audience' => 'nullable|string|max:255',
            'sent_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['is_read'] = $request->has('is_read') ? 1 : 0;

        $notification = Notification::create($data);

        // ---------- Broadcast real-time notification ----------
        if ($notification->user_id) {
            broadcast(new NotificationSent($notification, $notification->user_id))->toOthers();
        } else {
            // If no specific user, broadcast to all users (optional)
            // You can implement target_audience logic here
            // For now, we only broadcast if user_id is set.
        }

        return redirect()->route('admin.notification.index')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * Show the form for editing the specified notification.
     */
    public function edit(Notification $notification)
    {
        $users = User::all();
        return view('admin.notification.edit', compact('notification', 'users'));
    }

    /**
     * Update the specified notification.
     */
    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'nullable|string|max:50',
            'target_audience' => 'nullable|string|max:255',
            'sent_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['is_read'] = $request->has('is_read') ? 1 : 0;

        $notification->update($data);

        return redirect()->route('admin.notification.index')
            ->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified notification.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notification.index')
            ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Mark a notification as read (AJAX)
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true, 'read_at' => now()]);
        return response()->json(['success' => true]);
    }
}