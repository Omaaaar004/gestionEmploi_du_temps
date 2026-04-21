<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('seances.index');
        }
        return view('auth.login');
    }

    // Gérer la tentative de connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // FORCE LOGIN POUR L'ADMIN (Pour dépanage rapide)
        if ($credentials['email'] == 'admin@ump.ma' && $credentials['password'] == 'admin123') {
            $user = \App\Models\User::where('email', 'admin@ump.ma')->first();
            if ($user) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended('seances');
            }
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('seances');
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
