<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::search(
            $request->search,
            [
                'name',
                'email'
            ]
        );

        if ($request->filled('status')) {
            $query->where(
                'is_active',
                $request->status === 'active' ? 1 : 0
            );
        }

        $subscribers = $query
            ->latest()
            ->paginate(20);

        return view('admin.subscriber.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber deleted successfully.');
    }

    public function toggle(Subscriber $subscriber)
    {
        $subscriber->update([
            'is_active' => !$subscriber->is_active,
            'unsubscribed_at' => $subscriber->is_active ? now() : null,
        ]);

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber status updated successfully.');
    }
}