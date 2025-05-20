<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Summary of showLoginForm
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\AuthRequest $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function login(AuthRequest $request): RedirectResponse
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('message', 'Incorrectly entered data');
    }

    /**
     * Summary of logout
     * @return mixed|RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('admin.login.form');
    }
}
