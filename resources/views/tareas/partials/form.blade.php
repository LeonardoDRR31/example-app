@php
    $isEdit = isset($tarea) && $tarea;
@endphp

<form method="POST" action="{{ $action }}" class="panel form-grid">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="field-block">
        <label for="titulo">Titulo</label>
        <input
            id="titulo"
            name="titulo"
            type="text"
            value="{{ old('titulo', $tarea->titulo ?? '') }}"
            placeholder="Ejemplo: Preparar demo para cliente"
            required
            autofocus
        >
        @error('titulo')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-block">
        <label for="descripcion">Descripcion</label>
        <textarea
            id="descripcion"
            name="descripcion"
            rows="5"
            placeholder="Agrega contexto, entregables o notas importantes"
        >{{ old('descripcion', $tarea->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="inline-grid">
        <div class="field-block">
            <label for="prioridad">Prioridad</label>
            <select id="prioridad" name="prioridad" required>
                @foreach (['baja' => 'Baja', 'media' => 'Media', 'alta' => 'Alta'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('prioridad', $tarea->prioridad ?? 'media') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('prioridad')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field-block">
            <label for="fecha_limite">Fecha limite</label>
            <input
                id="fecha_limite"
                name="fecha_limite"
                type="date"
                value="{{ old('fecha_limite', isset($tarea?->fecha_limite) ? $tarea->fecha_limite->format('Y-m-d') : '') }}"
            >
            @error('fecha_limite')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <label class="checkbox-row">
        <input
            type="checkbox"
            name="completada"
            value="1"
            @checked(old('completada', $tarea->completada ?? false))
        >
        <span>Marcar como completada</span>
    </label>

    <div class="actions-row">
        <a href="{{ route('tareas.index') }}" class="btn ghost">Cancelar</a>
        <button type="submit" class="btn primary">{{ $buttonText }}</button>
    </div>
</form>
