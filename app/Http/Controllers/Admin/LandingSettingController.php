<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingSettingController extends Controller
{
    public function index()
    {
        $settings = LandingSetting::pluck('value', 'key')->toArray();
        $faqs = DB::table('faqs')->orderBy('urutan')->get();

        return view('admin.landing-settings.index', compact('settings', 'faqs'))->with('pageTitle', 'Pengaturan Landing');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',

            'about_badge' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',

            'about_feature_1_icon' => 'nullable|string|max:50',
            'about_feature_1_title' => 'nullable|string|max:255',
            'about_feature_1_desc' => 'nullable|string',
            'about_feature_2_icon' => 'nullable|string|max:50',
            'about_feature_2_title' => 'nullable|string|max:255',
            'about_feature_2_desc' => 'nullable|string',
            'about_feature_3_icon' => 'nullable|string|max:50',
            'about_feature_3_title' => 'nullable|string|max:255',
            'about_feature_3_desc' => 'nullable|string',
            'about_feature_4_icon' => 'nullable|string|max:50',
            'about_feature_4_title' => 'nullable|string|max:255',
            'about_feature_4_desc' => 'nullable|string',

            'brand_badge' => 'nullable|string|max:255',
            'brand_title' => 'nullable|string|max:255',
            'brand_description' => 'nullable|string',

            'promo_title' => 'nullable|string|max:255',
            'promo_description' => 'nullable|string',

            'steps_badge' => 'nullable|string|max:255',
            'steps_title' => 'nullable|string|max:255',
            'steps_description' => 'nullable|string',

            'testimonial_badge' => 'nullable|string|max:255',
            'testimonial_title' => 'nullable|string|max:255',
            'testimonial_description' => 'nullable|string',

            'faq_title' => 'nullable|string|max:255',
            'faq_description' => 'nullable|string',
            'selected_faq_ids' => 'nullable|array',
            'selected_faq_ids.*' => 'exists:faqs,id',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'selected_faq_ids') {
                $value = json_encode($value);
            }
            LandingSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan Landing Page berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('admin.landing-settings.index')
            ->with('success', 'Pengaturan Landing Page berhasil diperbarui.');
    }
}