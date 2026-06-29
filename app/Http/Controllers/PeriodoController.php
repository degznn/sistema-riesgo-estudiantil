<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodoRequest;
use App\Models\Periodo;

class PeriodoController extends Controller
{
    public function index()
    {
        $periodos = Periodo::orderByDesc('activo')->orderByDesc('id')->get();

        return view('periodos.index', compact('periodos'));
    }

    public function store(PeriodoRequest $request)
    {
        if ($request->has('activo')) {
            Periodo::query()->update(['activo' => false]);
        }

        Periodo::create([
            ...$request->safe()->only(['nombre', 'fecha_inicio', 'fecha_fin']),
            'activo' => $request->has('activo'),
        ]);

        return back()->with('success', 'Periodo academico registrado correctamente.');
    }

    public function update(PeriodoRequest $request, Periodo $periodo)
    {
        if ($request->has('activo')) {
            Periodo::whereKeyNot($periodo->id)->update(['activo' => false]);
        }

        $periodo->update([
            ...$request->safe()->only(['nombre', 'fecha_inicio', 'fecha_fin']),
            'activo' => $request->has('activo'),
        ]);

        return back()->with('success', 'Periodo academico actualizado correctamente.');
    }

    public function destroy(Periodo $periodo)
    {
        if ($periodo->estudiantes()->exists()) {
            return back()->with('error', 'No se puede eliminar un periodo con estudiantes asociados.');
        }

        $periodo->delete();

        return back()->with('success', 'Periodo academico eliminado correctamente.');
    }
}
