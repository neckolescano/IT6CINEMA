<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // We load the adminProfile relationship so the names are available in the view
        return view('profile.edit', [
            'user' => $request->user()->load('adminProfile'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Update the 'users' table (Only email, as name is moved to profile)
        $user->fill($request->safe()->only(['email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 2. Update the 'admin_profile' table based on your ERD
        // This ensures the first_name, middle_name, and last_name are saved correctly
        if ($user->isAdmin() && $user->adminProfile) {
            $user->adminProfile->update($request->safe()->only([
                'first_name', 
                'middle_name', 
                'last_name'
            ]));
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

        // Because we set up 'cascade' in the migration, 
        // deleting the user will automatically delete the admin_profile.
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}