@extends('layouts.app')

@section('title', 'Crear tarea')

@section('content')
    <section class="hero-card compact">
        <div>
            <p class="eyebrow">Nueva tarea</p>
            <h1>Crear tarea</h1>
            <p class="subtitle">Registra una actividad con prioridad, fecha limite y notas.</p>
        </div>
    </section>

    @include('tareas.partials.form', [
        'action' => route('tareas.store'),
        'method' => 'POST',
        'buttonText' => 'Guardar tarea',
        'tarea' => null,
    ])
@endsection
