<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     toastr()->closeButton(true)->addSuccess('Successfully login.');
    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        toastr()->closeButton(true)->addSuccess('Successfully login.');

        $user = auth()->user();

        // // === Redirect Berdasarkan Role ===
        // if ($user->hasRole(['Admin', 'Administrator'])) {
        //     return redirect()->intended('/dashboard/admin/letter');
        // }
        // if ($user->hasRole('Kasi')) {
        //     return redirect()->intended('/dashboard/kasi/letter'); 
        // }
        // if ($user->hasRole('Kabid')) {
        //     return redirect()->intended('/dashboard/kabid/letter');
        // }
        // if ($user->hasRole('Kasat')) {
        //     return redirect()->intended('/dashboard/kasat/letter');
        // }
        // if ($user->hasRole('Staff')) {
        //     return redirect()->intended('/dashboard/staff/letter');
        // }

        // Default fallback jika tidak punya role
        return redirect()->intended(RouteServiceProvider::HOME);
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
