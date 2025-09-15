<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller {
    public function create() {
        return view('login');
    }

    public function store(Request $request) {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]); // returns 422 + JSON errors for XHR automatically

        
        // $user = User::where('email', $credentials['email'])->first();
        $user = User::where('email', $credentials['email'])->first();

        // Validate if the user exists and it's the correct password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        // Log in the user (creates session)
        Auth::login($user);

        // On failure, send back an error
        return response()->json([
            'message' => 'Login successful',
            'redirect' => route('home'),
        ], 200);
    }

    public function destroy(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
