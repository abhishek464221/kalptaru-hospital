<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $query = Email::search(
            $request->search,
            [
                'to',
                'subject',
                'message',
                'status'
            ]
        );

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $emails = $query
            ->latest()
            ->paginate(20);

        return view('admin.email.index', compact('emails'));
    }

    public function create()
    {
        return view('admin.email.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_email' => 'required|email',
            'recipient_name' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
        ]);

        $data = $request->all();
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('email_attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }
        $data['attachments'] = $attachmentPaths;
        $email = Email::create([
            'recipient_email' => $data['recipient_email'],
            'recipient_name' => $data['recipient_name'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'attachments' => $data['attachments'],
            'status' => 'queued',
        ]);
        try {
            Mail::send([], [], function ($message) use ($email) {
                $message->to($email->recipient_email, $email->recipient_name)
                    ->subject($email->subject)
                    ->html($email->body);
                if ($email->attachments) {
                    foreach ($email->attachments as $attachment) {
                        $message->attach(storage_path('app/public/' . $attachment));
                    }
                }
            });

            $email->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return redirect()->route('admin.emails.index')
                ->with('success', 'Email sent successfully.');

        } catch (\Exception $e) {
            $email->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            return redirect()->route('admin.emails.index')
                ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function show(Email $email)
    {
        return view('admin.email.show', compact('email'));
    }

    public function destroy(Email $email)
    {
        if ($email->attachments) {
            foreach ($email->attachments as $attachment) {
                \Storage::disk('public')->delete($attachment);
            }
        }

        $email->delete();
        return redirect()->route('admin.emails.index')
            ->with('success', 'Email deleted successfully.');
    }

    public function resend(Email $email)
    {
        if ($email->status !== 'failed') {
            return redirect()->route('admin.emails.index')
                ->with('error', 'Only failed emails can be resent.');
        }

        try {
            Mail::send([], [], function ($message) use ($email) {
                $message->to($email->recipient_email, $email->recipient_name)
                    ->subject($email->subject)
                    ->html($email->body);

                if ($email->attachments) {
                    foreach ($email->attachments as $attachment) {
                        $message->attach(storage_path('app/public/' . $attachment));
                    }
                }
            });

            $email->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
            ]);

            return redirect()->route('admin.emails.index')
                ->with('success', 'Email resent successfully.');

        } catch (\Exception $e) {
            $email->update([
                'error_message' => $e->getMessage(),
            ]);

            return redirect()->route('admin.emails.index')
                ->with('error', 'Failed to resend email: ' . $e->getMessage());
        }
    }
}