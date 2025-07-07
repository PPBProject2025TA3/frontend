<h4>Agregar comentario</h4>

<form method="POST" action="/tareas/{{ $tarea_id }}/comentarios">
    @csrf
    <textarea name="contenido" required></textarea><br>
    <button type="submit">Comentar</button>
</form>
