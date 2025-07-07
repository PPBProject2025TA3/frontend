@extends('layouts.guest')

@section('content')
<h2>Login</h2>

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form method="POST" action="/login">
    @csrf
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Contraseña:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Iniciar sesión</button>
</form>
@endsection
