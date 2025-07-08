@extends('layouts.guest')

@section('content')
<h2>Registro</h2>

<form method="POST" action="/register">
    @csrf
    <label>Nombre:</label>
    <input type="text" name="name" required><br>
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Contraseña:</label>
    <input type="password" name="password" required><br>
    <label>Confirmar contraseña:</label>
    <input type="password" name="password_confirmation" required><br>
    <button type="submit">Registrarse</button>
</form>
@endsection
