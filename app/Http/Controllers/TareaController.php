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
        $response = Http::get("http://localhost:8001/api/tareas/{$id}");
        $tarea = $response->json();

        if (!$tarea) {
            abort(404);
        }

        $comentarios = $tarea['comentarios'] ?? [];

        $authUser = session('auth_user');
        $puedeEditar = $authUser && isset($authUser['id']) && $authUser['id'] == $tarea['autor_id'];

        return view('tareas.show', [
            'tarea' => $tarea,
            'comentarios' => $comentarios,
            'token' => session('token'),
            'puedeEditar' => $puedeEditar,
        ]);
    }




    public function create()
    {
        return view('tareas.create');
    }

    public function store(Request $request)
    {
        $token = session('token');

        $categorias = array_map('trim', explode(',', $request->categorias ?? ''));

        $usuarios_asignados = [];

        $fecha_expiracion = \Carbon\Carbon::createFromFormat(
            'Y-m-d\TH:i', 
            $request->fecha_expiracion
        )->format('Y-m-d H:i:s');

        $data = [
            "titulo" => $request->titulo,
            "estado_actual" => "pendiente",
            "usuario_creador_id" => 1,
            "fecha_hora" => "2025-07-06 22:30:00",
            "accion" => "creacion",
            "autor_id" => 1,
            "descripcion" => $request->cuerpo,
            "fecha_inicio" => "2025-07-06 20:00:00",
            "fecha_vencimiento" => $fecha_expiracion,
            "estado" => "pendiente",
            "categorias" => $categorias,
            "asignados" => $usuarios_asignados,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ])->post('http://localhost:8001/api/tareas', $data);

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
