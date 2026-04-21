<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting ; 

class SettingsController extends Controller
{
     public function index()
    {
        $settings = [
            'store_name' => Setting::getValue('store_name', 'Aura.'),
            'contact_email' => Setting::getValue('contact_email', 'hello@aura.com'),
            'currency' => Setting::getValue('currency', 'USD'),
            'timezone' => Setting::getValue('timezone', 'PT'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'currency' => 'required|string|in:USD,EUR,GBP',
            'timezone' => 'required|string|in:PT,ET,UTC',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated.');
    }
}
