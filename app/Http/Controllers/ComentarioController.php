<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComentarioController extends Controller
{
    public function store(Request $request, $tareaId)
    {
        $token = session('token');

        $response = Http::withToken($token)->post("http://localhost:8001/api/tareas/{$tareaId}/comentarios", [
            'contenido' => $request->contenido
        ]);

        return redirect("/tareas/{$tareaId}");
    }
}
