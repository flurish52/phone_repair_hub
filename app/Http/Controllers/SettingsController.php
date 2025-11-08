<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SettingsController extends Controller
{

    public function index()
    {
        return inertia::render('Settings', [
            'user' =>  Auth::user(),
        ]);
    }



    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|unique:users,phone,' . $user->id,
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'settings' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Generate slug and username
        $data['slug'] = Str::slug($data['name']);
        $data['username'] = strtolower(strtok($data['name'], ' '));

        $user->update($data);

        return back()->with('success', 'Profile updated');
    }



}
