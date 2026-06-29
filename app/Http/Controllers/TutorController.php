<?php

namespace App\Http\Controllers;

use App\Http\Requests\TutorRequest;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TutorController extends Controller
{
    public function index()
    {
        $tutores = Tutor::with('user')->orderByDesc('id')->get();

        return view('tutores.index', compact('tutores'));
    }

    public function store(TutorRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'tutor',
            'password' => Hash::make($data['password']),
        ]);

        Tutor::create([
            'user_id' => $user->id,
            'codigo' => $data['codigo'],
            'telefono' => $data['telefono'] ?? null,
            'especialidad' => $data['especialidad'] ?? null,
            'activo' => true,
        ]);

        return back()->with('success', 'Tutor registrado correctamente.');
    }

    public function update(TutorRequest $request, Tutor $tutor)
    {
        $data = $request->validated();

        $tutor->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (!empty($data['password'])) {
            $tutor->user->update(['password' => Hash::make($data['password'])]);
        }

        $tutor->update([
            'codigo' => $data['codigo'],
            'telefono' => $data['telefono'] ?? null,
            'especialidad' => $data['especialidad'] ?? null,
            'activo' => $request->boolean('activo'),
        ]);

        return back()->with('success', 'Tutor actualizado correctamente.');
    }

    public function destroy(Tutor $tutor)
    {
        $tutor->user->delete();

        return back()->with('success', 'Tutor eliminado correctamente.');
    }
}
