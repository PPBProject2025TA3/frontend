@extends('layouts.app')

@section('content')
<h2>Crear nueva tarea</h2>

<form method="POST" action="/tareas">
    @csrf
    <label>Título:</label>
    <input type="text" name="titulo" required><br>

    <label>Cuerpo:</label>
    <textarea name="cuerpo" required></textarea><br>

    <label>Fecha de expiración (opcional):</label>
    <input type="datetime-local" name="fecha_expiracion"><br>

    <label>Categorías (separadas por coma):</label>
    <input type="text" name="categorias"><br>

    <button type="submit">Crear</button>
</form>
@endsection
