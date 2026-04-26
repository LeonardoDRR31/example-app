@extends('layouts.app')

@section('title', 'Editar tarea')

@section('content')
    <section class="hero-card compact">
        <div>
            <p class="eyebrow">Actualizar tarea</p>
            <h1>Editar tarea</h1>
            <p class="subtitle">Ajusta el contenido y mantén tu plan al dia.</p>
        </div>
    </section>

    @include('tareas.partials.form', [
        'action' => route('tareas.update', $tarea),
        'method' => 'PUT',
        'buttonText' => 'Actualizar tarea',
        'tarea' => $tarea,
    ])
@endsection
