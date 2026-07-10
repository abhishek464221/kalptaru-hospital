<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    /**
     * Display a listing of emails.
     */
    public function index(Request $request)
    {
        $query = Email::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $emails = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.email.index', compact('emails'));
    }

    /**
     * Show the form for creating a new email.
     */
    public function create()
    {
        return view('admin.email.create');
    }

    /**
     * Store a newly created email and send it.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_email' => 'required|email',
            'recipient_name' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120', // 5MB per file
        ]);

        $data = $request->all();

        // Handle file attachments
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('email_attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }
        $data['attachments'] = $attachmentPaths;

        // Create email record
        $email = Email::create([
            'recipient_email' => $data['recipient_email'],
            'recipient_name' => $data['recipient_name'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'attachments' => $data['attachments'],
            'status' => 'queued',
        ]);

        // Try to send email
        try {
            Mail::send([], [], function ($message) use ($email) {
                $message->to($email->recipient_email, $email->recipient_name)
                    ->subject($email->subject)
                    ->html($email->body);

                // Attach files if any
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

    /**
     * Display the specified email.
     */
    public function show(Email $email)
    {
        return view('admin.email.show', compact('email'));
    }

    /**
     * Remove the specified email.
     */
    public function destroy(Email $email)
    {
        // Delete attachments from storage
        if ($email->attachments) {
            foreach ($email->attachments as $attachment) {
                \Storage::disk('public')->delete($attachment);
            }
        }

        $email->delete();
        return redirect()->route('admin.emails.index')
            ->with('success', 'Email deleted successfully.');
    }

    /**
     * Resend a failed email.
     */
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