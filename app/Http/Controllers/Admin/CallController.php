<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\User;
use App\Events\CallOffer;
use App\Events\CallAnswer;
use App\Events\CallIceCandidate;
use App\Events\CallEnd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallController extends Controller
{
    // ==================== WEBRTC SIGNALING METHODS ====================

    /**
     * Send a call offer to the receiver
     */
    public function offer(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'offer' => 'required',
            'call_type' => 'required|in:audio,video'
        ]);

        $receiver = User::find($request->receiver_id);
        broadcast(new CallOffer(Auth::id(), $receiver->id, $request->offer, $request->call_type));

        return response()->json(['status' => 'offer sent']);
    }

    /**
     * Send a call answer back to the caller
     */
    public function answer(Request $request)
    {
        $request->validate([
            'caller_id' => 'required|exists:users,id',
            'answer' => 'required',
        ]);

        broadcast(new CallAnswer($request->caller_id, Auth::id(), $request->answer))->toOthers();

        return response()->json(['status' => 'answer sent']);
    }

    /**
     * Relay ICE candidates between peers
     */
    public function iceCandidate(Request $request)
    {
        $request->validate([
            'target_id' => 'required|exists:users,id',
            'candidate' => 'required',
        ]);

        broadcast(new CallIceCandidate($request->target_id, Auth::id(), $request->candidate))->toOthers();

        return response()->json(['status' => 'candidate sent']);
    }

    /**
     * End the call and log it
     */
    public function endCall(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'duration_seconds' => 'nullable|integer',
        ]);

        $receiver = User::find($request->receiver_id);

        // Log the call
        Call::create([
            'user_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'caller_name' => Auth::user()->name,
            'receiver_name' => $receiver->name,
            'call_datetime' => now(),
            'duration_seconds' => $request->duration_seconds ?? 0,
            'call_type' => 'audio', // Default, but you can detect if needed
            'direction' => 'outgoing',
            'notes' => null,
            'follow_up_required' => false,
            'follow_up_date' => null,
        ]);

        broadcast(new CallEnd(Auth::id(), $request->receiver_id))->toOthers();

        return response()->json(['status' => 'call ended']);
    }


    // ==================== VIEW METHODS (FOR SIDEBAR LINKS) ====================

    /**
     * Display call history for the logged-in user
     */
    public function history()
    {
        $calls = Call::where('user_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.calls.history', compact('calls'));
    }

    /**
     * Show form to manually add a call log
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.calls.create', compact('users'));
    }

    /**
     * Store a manually added call log
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'call_type' => 'required|in:audio,video',
            'direction' => 'required|in:incoming,outgoing',
            'duration_seconds' => 'nullable|integer',
            'notes' => 'nullable|string',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'nullable|date',
        ]);

        $user = User::find($request->user_id);

        Call::create([
            'user_id' => Auth::id(),
            'receiver_id' => $request->user_id,
            'caller_name' => Auth::user()->name,
            'receiver_name' => $user->name,
            'call_datetime' => now(),
            'duration_seconds' => $request->duration_seconds ?? 0,
            'call_type' => $request->call_type,
            'direction' => $request->direction,
            'notes' => $request->notes,
            'follow_up_required' => $request->follow_up_required ?? false,
            'follow_up_date' => $request->follow_up_date,
        ]);

        return redirect()->route('admin.calls.history')
                         ->with('success', 'Call log added successfully.');
    }

    /**
     * Voice Call Page (standalone, can be used to initiate a call)
     */
    public function voiceCall()
    {
        // For simplicity, we just show a page with a call button
        // In real usage, you might want to pass a user list or a specific user
        return view('admin.calls.voice');
    }

    /**
     * Video Call Page (standalone)
     */
    public function videoCall()
    {
        return view('admin.calls.video');
    }

    /**
     * Incoming Call Page (simulated incoming call)
     */
    public function incomingCall()
    {
        return view('admin.calls.incoming');
    }
}