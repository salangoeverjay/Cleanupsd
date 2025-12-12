<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserDetail;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        $userDetails = $user->details;

        return view('profile.edit', compact('user', 'userDetails'));
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'usr_name' => 'required|string|max:255',
            'email_add' => 'required|email|max:255',
            'contact_num' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // Update user name
        $user->usr_name = $request->usr_name;
        $user->save();

        // Update or create user details
        UserDetail::updateOrCreate(
            ['usr_id' => $user->usr_id],
            [
                'email_add' => $request->email_add,
                'contact_num' => $request->contact_num,
                'address' => $request->address,
            ]
        );

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
