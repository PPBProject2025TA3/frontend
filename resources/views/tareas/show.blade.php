@extends('layouts.app')

@section('content')
<h2>{{ $tarea['titulo'] }}</h2>
<p><strong>Descripción:</strong> {{ $tarea['cuerpo'] }}</p>
<p><strong>Autor ID:</strong> {{ $tarea['autor_id'] }}</p>
<p><strong>Estado:</strong> {{ $tarea['estado'] }}</p>
<p><strong>Fecha creación:</strong> {{ $tarea['created_at'] }}</p>

@if ($puedeEditar)
    <a href="/tareas/{{ $tarea['id'] }}/edit">Editar</a>
    <form method="POST" action="/tareas/{{ $tarea['id'] }}" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>
@endif

<hr>
<h3>Comentarios</h3>

@foreach ($comentarios as $comentario)
    <p>{{ $comentario['contenido'] }} - <i>por usuario {{ $comentario['usuario_id'] }}</i></p>
@endforeach

@if ($token)
    @include('tareas.comentarios', ['tarea_id' => $tarea['id']])
@endif

@endsection
