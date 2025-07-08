<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthCustom
{
    public function handle(Request $request, Closure $next)
    {
        $token = session('token');

        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get('http://localhost:8000/api/me');

        if ($response->failed()) {
            session()->forget('token');
            return redirect('/login');
        }

        $request->merge(['auth_user' => $response->json()]);

        return $next($request);
    }
}
