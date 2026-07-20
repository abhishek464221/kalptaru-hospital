<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;
use App\Events\MessageSeen;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        $unreadCounts = [];
        $latestMessages = [];

        foreach ($users as $user) {
            $unreadCounts[$user->id] = Chat::where('sender_id', $user->id)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->count();

            $latest = Chat::where(function ($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
            })->latest()->first();

            $latestMessages[$user->id] = $latest;
        }

        return view('admin.chat.index', compact('users', 'unreadCounts', 'latestMessages'));
    }

    public function show(User $user)
    {
        $messages = Chat::conversation(Auth::id(), $user->id);

        $unreadMessages = Chat::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->get();

        foreach ($unreadMessages as $msg) {
            $msg->markAsSeen();
            try {
                broadcast(new MessageSeen($msg->id, $msg->sender_id, $msg->receiver_id));
            } catch (\Exception $e) {
            }
        }

        return view('admin.chat.conversation', compact('user', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000',
            'attachments.*' => 'nullable|file|max:20480',
            'attachments' => 'max:5',
        ]);

        $attachmentPaths = [];
        $attachmentTypes = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('uploads/chats', 'public');
                $attachmentPaths[] = $path;
                $attachmentTypes[] = $file->getMimeType();
            }
        }

        if (empty($request->message) && empty($attachmentPaths)) {
            return response()->json([
                'success' => false,
                'message' => 'Please send a message or a file.'
            ], 422);
        }

        $message = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message ?? '',
            'attachment' => $attachmentPaths,
            'attachment_type' => $attachmentTypes,
            'status' => 'sent',
            'is_read' => false,
        ]);

        try {
            broadcast(new NewMessage($message))->toOthers();
        } catch (\Exception $e) {
            // ignore
        }

        return response()->json([
            'success' => true,
            'message' => $message->load('sender'),
        ]);
    }

    public function markRead(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $messages = Chat::where('sender_id', $request->user_id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->get();

        foreach ($messages as $msg) {
            $msg->markAsSeen();
            try {
                broadcast(new MessageSeen($msg->id, $msg->sender_id, $msg->receiver_id));
            } catch (\Exception $e) {
               
            }
        }

        return response()->json(['success' => true]);
    }

    public function unreadCount()
    {
        $count = Chat::unreadCount(Auth::id());
        return response()->json(['count' => $count]);
    }

    public function onlineStatus(Request $request)
    {
        $userId = $request->user_id;
        $user = User::find($userId);
        if ($user) {
            return response()->json([
                'online' => $user->isOnline(),
                'last_seen' => $user->last_seen ? $user->last_seen->diffForHumans() : 'Never'
            ]);
        }
        return response()->json(['online' => false, 'last_seen' => 'Unknown']);
    }
}