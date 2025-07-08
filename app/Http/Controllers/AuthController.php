<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($response->successful()) {
            session(['token' => $response['access_token']]);
            return redirect('/');
        }

        return back()->with('error', 'Credenciales inválidas');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation
        ]);

        if ($response->successful()) {
            session(['token' => $response['access_token']]);
            return redirect('/');
        }

        return back()->with('error', 'Registro fallido');
    }

    public function logout()
    {
        session()->forget('token');
        return redirect('/login');
    }
}
