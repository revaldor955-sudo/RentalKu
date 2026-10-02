<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (AJAX from profile modal).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }

            $folder = public_path('images/users');
            if (!File::isDirectory($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move($folder, $photoName);
            $validated['photo'] = 'images/users/' . $photoName;
        }

        // Remove photo key if no file uploaded (don't null existing)
        if (!$request->hasFile('photo') && !$request->has('remove_photo')) {
            unset($validated['photo']);
        }

        // Handle remove photo
        if ($request->has('remove_photo') && $request->remove_photo) {
            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }
            $validated['photo'] = null;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // AJAX request → JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui.',
                'user'    => [
                    'name'      => $user->name,
                    'email'     => $user->email,
                    'phone'     => $user->phone,
                    'address'   => $user->address,
                    'photo_url' => $user->photo ? asset($user->photo) : null,
                ],
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
