<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('adminPages.login');
    }

    public function loginpost(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        AdminController::updateAuditTrail('Logged in');
        
        $hasUserRole = Auth::user()->hasRole('user');
        return response()->json([
            'has_user_role' => $hasUserRole,
            'role' => Auth::user()->getRoleNames()
        ]);
    
        if (Auth::user()->hasRole('user')) {
            return redirect()->intended('/profile');
        }if (Auth::user()->hasRole('administrator')) {
            return redirect()->intended('/admin-home');
        } else {
            return redirect()->intended('/dashboard');
        }
    }
}
