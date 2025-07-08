@extends('layouts.app')

@section('content')
<h2>Listado de Tareas</h2>

@foreach ($tareas as $tarea)
    <div>
        <h3><a href="/tareas/{{ $tarea['id'] }}">{{ $tarea['titulo'] }}</a></h3>
        <p>{{ $tarea['cuerpo'] }}</p>
        <p><strong>Estado:</strong> {{ $tarea['estado'] }}</p>
        <hr>
    </div>
@endforeach
@endsection
