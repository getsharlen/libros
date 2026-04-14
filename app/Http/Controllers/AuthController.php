<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        $user = User::create([
            ...$request->safe()->except('password'),
            'password' => Hash::make((string) $request->input('password')),
            'role' => 'siswa',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if (! $request->expectsJson()) {
            return redirect()
                ->route('siswa.dashboard')
                ->with('success', 'Registrasi berhasil. Selamat datang di Libros.');
        }

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'data' => $user,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->safe()->only(['email', 'password']);

        if (! Auth::attempt($credentials)) {
            if (! $request->expectsJson()) {
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors(['email' => 'Email atau password tidak valid.']);
            }

            return response()->json([
                'message' => 'Email atau password tidak valid.',
            ], 422);
        }

        $request->session()->regenerate();

        $redirectTo = Auth::user()->isAdmin() ? 'admin.dashboard' : 'siswa.dashboard';

        if (! $request->expectsJson()) {
            return redirect()
                ->route($redirectTo)
                ->with('success', 'Login berhasil.');
        }

        return response()->json([
            'message' => 'Login berhasil.',
            'redirect_to' => route($redirectTo),
        ]);
    }

    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (! $request->expectsJson()) {
            return redirect()->route('login.form')->with('success', 'Logout berhasil.');
        }

        return response()->json([
            'message' => 'Logout berhasil.',
        ]);
    }
}
