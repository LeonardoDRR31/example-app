<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TareaController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'estado' => ['nullable', Rule::in(['todas', 'pendientes', 'completadas'])],
        ]);

        $estado = $validated['estado'] ?? 'todas';

        $query = Tarea::query();

        if (! empty($validated['q'])) {
            $query->where(function ($innerQuery) use ($validated) {
                $innerQuery
                    ->where('titulo', 'like', '%' . $validated['q'] . '%')
                    ->orWhere('descripcion', 'like', '%' . $validated['q'] . '%');
            });
        }

        if ($estado === 'pendientes') {
            $query->where('completada', false);
        }

        if ($estado === 'completadas') {
            $query->where('completada', true);
        }

        $tareas = $query
            ->orderBy('completada')
            ->orderByRaw('fecha_limite is null')
            ->orderBy('fecha_limite')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('tareas.index', [
            'tareas' => $tareas,
            'estado' => $estado,
            'q' => $validated['q'] ?? '',
            'statsTotal' => Tarea::count(),
            'statsCompletadas' => Tarea::where('completada', true)->count(),
            'statsPendientes' => Tarea::where('completada', false)->count(),
        ]);
    }

    public function create(): View
    {
        return view('tareas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateTarea($request);
        $data['completada'] = $request->boolean('completada');

        Tarea::create($data);

        return redirect()
            ->route('tareas.index')
            ->with('status', 'Tarea creada correctamente.');
    }

    public function edit(Tarea $tarea): View
    {
        return view('tareas.edit', compact('tarea'));
    }

    public function update(Request $request, Tarea $tarea): RedirectResponse
    {
        $data = $this->validateTarea($request);
        $data['completada'] = $request->boolean('completada');

        $tarea->update($data);

        return redirect()
            ->route('tareas.index')
            ->with('status', 'Tarea actualizada correctamente.');
    }

    public function destroy(Tarea $tarea): RedirectResponse
    {
        $tarea->delete();

        return redirect()
            ->route('tareas.index')
            ->with('status', 'Tarea eliminada.');
    }

    public function toggle(Tarea $tarea): RedirectResponse
    {
        $tarea->update(['completada' => ! $tarea->completada]);

        return redirect()
            ->route('tareas.index')
            ->with('status', 'Estado de la tarea actualizado.');
    }

    private function validateTarea(Request $request): array
    {
        return $request->validate([
            'titulo' => ['required', 'string', 'max:140'],
            'descripcion' => ['nullable', 'string', 'max:5000'],
            'prioridad' => ['required', Rule::in(['baja', 'media', 'alta'])],
            'fecha_limite' => ['nullable', 'date'],
            'completada' => ['nullable', 'boolean'],
        ]);
    }
}