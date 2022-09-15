<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(): View
    {
        return view('admin.login');
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            if (auth()->user()->isUser()) {
                return redirect()->intended(route('user.dashboard'));
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
