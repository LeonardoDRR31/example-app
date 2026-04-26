@extends('layouts.app')

@section('title', 'Tareas')

@section('content')
    <section class="hero-card">
        <div>
            <p class="eyebrow">Organiza tu dia sin friccion</p>
            <h1>CRUD de Tareas</h1>
            <p class="subtitle">Interfaz limpia, acciones claras y foco total en productividad.</p>
        </div>
        <a href="{{ route('tareas.create') }}" class="btn primary">Nueva tarea</a>
    </section>

    @if (session('status'))
        <div class="flash-success">{{ session('status') }}</div>
    @endif

    <section class="stats-grid">
        <article class="stat-card">
            <span>Total</span>
            <strong>{{ $statsTotal }}</strong>
        </article>
        <article class="stat-card">
            <span>Pendientes</span>
            <strong>{{ $statsPendientes }}</strong>
        </article>
        <article class="stat-card">
            <span>Completadas</span>
            <strong>{{ $statsCompletadas }}</strong>
        </article>
    </section>

    <section class="panel filter-wrap">
        <form method="GET" class="filter-form">
            <input
                type="search"
                name="q"
                value="{{ $q }}"
                placeholder="Busca por titulo o descripcion"
            >
            <select name="estado">
                <option value="todas" @selected($estado === 'todas')>Todas</option>
                <option value="pendientes" @selected($estado === 'pendientes')>Pendientes</option>
                <option value="completadas" @selected($estado === 'completadas')>Completadas</option>
            </select>
            <button type="submit" class="btn soft">Filtrar</button>
        </form>
    </section>

    @if ($tareas->isEmpty())
        <section class="panel empty-state">
            <h2>No hay tareas para mostrar</h2>
            <p>Crea una nueva tarea para empezar a organizar tu flujo de trabajo.</p>
            <a href="{{ route('tareas.create') }}" class="btn primary">Crear primera tarea</a>
        </section>
    @else
        <section class="cards-grid">
            @foreach ($tareas as $tarea)
                <article class="task-card {{ $tarea->completada ? 'is-completed' : '' }}">
                    <div class="task-header">
                        <span class="badge {{ 'priority-' . $tarea->prioridad }}">{{ ucfirst($tarea->prioridad) }}</span>
                        <span class="task-date">
                            {{ $tarea->fecha_limite ? $tarea->fecha_limite->format('d/m/Y') : 'Sin fecha' }}
                        </span>
                    </div>

                    <h3>{{ $tarea->titulo }}</h3>
                    <p>{{ $tarea->descripcion ?: 'Sin descripcion adicional.' }}</p>

                    <div class="task-actions">
                        <form method="POST" action="{{ route('tareas.toggle', $tarea) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn soft">
                                {{ $tarea->completada ? 'Marcar pendiente' : 'Marcar completa' }}
                            </button>
                        </form>

                        <a href="{{ route('tareas.edit', $tarea) }}" class="btn ghost">Editar</a>

                        <form method="POST" action="{{ route('tareas.destroy', $tarea) }}" onsubmit="return confirm('¿Eliminar esta tarea?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn danger">Eliminar</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="pagination-wrap">
            {{ $tareas->links() }}
        </div>
    @endif
@endsection
