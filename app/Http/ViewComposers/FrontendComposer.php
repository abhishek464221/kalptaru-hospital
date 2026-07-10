<?php

namespace App\Http\ViewComposers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Setting;
use Illuminate\View\View;

class FrontendComposer
{
    public function compose(View $view)
    {
        // Get all settings as key-value pairs
        $settings = Setting::pluck('value', 'key')->toArray();

        $departments = Department::all();
        $homeDoctors = Doctor::where('is_active', true)->limit(6)->get();

        $view->with([
            'departments' => $departments,
            'homeDoctors' => $homeDoctors,
            'settings' => $settings,  
        ]);
    }
}