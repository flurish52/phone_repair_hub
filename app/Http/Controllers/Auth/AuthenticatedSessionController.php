<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request)
    {
        $auth = $this->authenticate($request);

        if ($auth instanceof \Illuminate\Http\JsonResponse) {
            return $auth;
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Authentication failed.',
            ], 401);
        }

        $user->update(['last_login' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'redirect' => route('dashboard'),
        ]);
    }



    protected function authenticate($request)
    {
        $login = $request->input('login');

        $user = \App\Models\User::where('email', $login)
            ->orWhere('phone', $login)
            ->orWhere('username', $login)
            ->first();

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found',
            ], 404);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid credentials',
            ], 401);
        }


        Auth::login($user, $request->boolean('remember'));
        return $user;
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
