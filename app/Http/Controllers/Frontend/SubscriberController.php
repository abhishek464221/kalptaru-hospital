<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $subscriber = Subscriber::create([
                'email' => $request->email,
                'is_active' => true,
                'subscribed_at' => now(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subscribed successfully!',
                    'data' => $subscriber
                ]);
            }

            return redirect()->back()->with('success', 'Subscribed successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subscription failed. Please try again.'
                ], 500);
            }
            return redirect()->back()->with('error', 'Subscription failed. Please try again.');
        }
    }
}