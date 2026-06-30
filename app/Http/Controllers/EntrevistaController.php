<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntrevistaRequest;
use App\Models\Entrevista;
use App\Models\Estudiante;
use App\Repositories\EntrevistaRepository;
use App\Services\EntrevistaService;
use Illuminate\Http\Request;

class EntrevistaController extends Controller
{
    public function __construct(
        private EntrevistaRepository $entrevistas,
        private EntrevistaService $entrevistaService
    ) {
    }

    public function index(Request $request)
    {
        return view('entrevistas.index', [
            'entrevistas' => $this->entrevistas->latestForUser($request->user()),
        ]);
    }

    public function create(Request $request, Estudiante $estudiante)
    {
        $this->authorize('create', [Entrevista::class, $estudiante]);

        return view('entrevistas.create', compact('estudiante'));
    }

    public function store(EntrevistaRequest $request, Estudiante $estudiante)
    {
        $this->authorize('create', [Entrevista::class, $estudiante]);

        $this->entrevistaService->registrar($estudiante, $request->validated());

        return redirect()->route('entrevistas.index')->with('success', 'Entrevista registrada correctamente.');
    }
}
