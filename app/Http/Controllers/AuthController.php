<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://localhost:8000/oauth/token', [
            'grant_type' => 'password',
            'client_id' => '1',
            'client_secret' => 'y6lkgtkgGo5GEQkgiASzDrxBJm1QqsrbkOyNAB5X',
            'username' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            session(['token' => $response['access_token']]);
            return redirect('/');
        }

        return back()->with('error', 'Credenciales inválidas');
    }

    public function register(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://localhost:8000/api/user', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Registro exitoso. Ahora iniciá sesión.');
        }

        return back()->with('error', 'Registro fallido');
    }

    public function logout()
    {
        $token = session('token');

        if ($token) {
            Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://localhost:8000/api/logout');
        }

        session()->forget('token');
        return redirect('/login');
    }
        public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }
}
