<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TareaController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8001/api/tareas');
        $tareas = $response->json();

        return view('tareas.index', compact('tareas'));
    }

    public function show($id)
    {
        $token = session('token');

        $tarea = Http::get("http://localhost:8001/api/tareas/{$id}")->json();
        $comentarios = Http::get("http://localhost:8001/api/tareas/{$id}/comentarios")->json();

        $puedeEditar = false;

        if ($token) {
            $user = Http::withToken($token)->get('http://localhost:8000/api/me')->json();
            $puedeEditar = $tarea['autor_id'] == $user['id'];
        }

        return view('tareas.show', compact('tarea', 'comentarios', 'puedeEditar', 'token'));
    }

    public function create()
    {
        return view('tareas.create');
    }

    public function store(Request $request)
    {
        $token = session('token');

        $categorias = array_map('trim', explode(',', $request->categorias ?? ''));

        $data = [
            'titulo' => $request->titulo,
            'cuerpo' => $request->cuerpo,
            'usuario_asignado_id' => $request->usuario_asignado_id,
            'fecha_expiracion' => $request->fecha_expiracion,
            'categorias' => $categorias,
        ];

        $response = Http::withToken($token)->post('http://localhost:8001/api/tareas', $data);

        if ($response->successful()) {
            return redirect('/');
        }

        return back()->with('error', 'Error al crear la tarea');
    }

    public function edit($id)
    {
        $token = session('token');
        $tarea = Http::get("http://localhost:8001/api/tareas/{$id}")->json();

        return view('tareas.edit', compact('tarea'));
    }

    public function update(Request $request, $id)
    {
        $token = session('token');

        $categorias = array_map('trim', explode(',', $request->categorias ?? ''));

        $data = [
            'titulo' => $request->titulo,
            'cuerpo' => $request->cuerpo,
            'usuario_asignado_id' => $request->usuario_asignado_id,
            'fecha_expiracion' => $request->fecha_expiracion,
            'categorias' => $categorias,
        ];

        $response = Http::withToken($token)->put("http://localhost:8001/api/tareas/{$id}", $data);

        if ($response->successful()) {
            return redirect("/tareas/{$id}");
        }

        return back()->with('error', 'Error al actualizar');
    }

    public function destroy($id)
    {
        $token = session('token');
        $response = Http::withToken($token)->delete("http://localhost:8001/api/tareas/{$id}");

        return redirect('/');
    }
}
