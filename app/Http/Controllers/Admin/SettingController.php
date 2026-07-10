<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display company settings form.
     */
    public function index()
    {
        $settings = Setting::getMany([
            'company_name',
            'contact_person',
            'address',
            'country',
            'city',
            'state',
            'postal_code',
            'email',
            'phone',
            'mobile',
            'fax',
            'website',
            'logo_header',      // ✅ 
            'logo_footer',      // ✅
            'facebook_url',     // ✅ _url
            'twitter_url',
            'instagram_url',
            'linkedin_url',
        ]);

        return view('admin.setting.index', compact('settings'));
    }

    /**
     * Update company settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
        ]);

        $keys = [
            'company_name',
            'contact_person',
            'address',
            'country',
            'city',
            'state',
            'postal_code',
            'email',
            'phone',
            'mobile',
            'fax',
            'website',
            'facebook_url',   
            'twitter_url',
            'instagram_url',
            'linkedin_url',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->$key);
            }
        }

        // Logo Upload
        if ($request->hasFile('logo_header')) {
            $path = $request->file('logo_header')->store('settings', 'public');
            Setting::set('logo_header', $path);
        }
        if ($request->hasFile('logo_footer')) {
            $path = $request->file('logo_footer')->store('settings', 'public');
            Setting::set('logo_footer', $path);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}