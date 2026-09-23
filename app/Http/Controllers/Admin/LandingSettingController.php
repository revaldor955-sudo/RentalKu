<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    public function edit()
    {
        $settings = LandingSetting::pluck('value', 'key')->toArray();

        return view('admin.landing-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',

            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',

            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',

            'brand_title' => 'nullable|string|max:255',
            'brand_description' => 'nullable|string',

            'promo_title' => 'nullable|string|max:255',
            'promo_description' => 'nullable|string',

            'feature_title' => 'nullable|string|max:255',
            'feature_description' => 'nullable|string',

            'steps_title' => 'nullable|string|max:255',
            'steps_description' => 'nullable|string',

            'testimonial_title' => 'nullable|string|max:255',
            'testimonial_description' => 'nullable|string',

            'faq_title' => 'nullable|string|max:255',
            'faq_description' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            LandingSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('admin.landing-settings.edit')
            ->with('success', 'Pengaturan Landing Page berhasil diperbarui.');
    }
}