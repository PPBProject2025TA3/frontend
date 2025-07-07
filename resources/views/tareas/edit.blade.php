@extends('layouts.app')

@section('content')
<h2>Editar tarea</h2>

<form method="POST" action="/tareas/{{ $tarea['id'] }}">
    @csrf
    @method('PUT')

    <label>Título:</label>
    <input type="text" name="titulo" value="{{ $tarea['titulo'] }}" required><br>

    <label>Cuerpo:</label>
    <textarea name="cuerpo" required>{{ $tarea['cuerpo'] }}</textarea><br>

    <label>Usuario asignado (ID):</label>
    <input type="number" name="usuario_asignado_id" value="{{ $tarea['usuario_asignado_id'] }}"><br>

    <label>Fecha de expiración:</label>
    <input type="date" name="fecha_expiracion" value="{{ $tarea['fecha_expiracion'] }}"><br>

    <label>Categorías (separadas por coma):</label>
    <input type="text" name="categorias" value="{{ implode(',', $tarea['categorias'] ?? []) }}"><br>

    <button type="submit">Actualizar</button>
</form>
@endsection
