<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use Illuminate\Http\Request;

class GestionMatiereController extends Controller
{
    public function index()
    {
        $matieres = Matiere::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.matieres.matieres', compact('matieres'));
    }

    public function show(Matiere $matiere)
    {
        return view('admin.matieres.matiere-show', compact('matiere'));
    }

    public function create()
    {
        return view('admin.matieres.matiere-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:matieres',
            'description' => 'nullable|string|max:1000',
        ]);

        Matiere::create($validated);

        return redirect()->route('gestion-matieres.index')->with('success', 'Matière créée avec succès.');
    }

    public function edit(Matiere $matiere)
    {
        return view('admin.matieres.matiere-edit', compact('matiere'));
    }

    public function update(Request $request, Matiere $matiere)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:matieres,nom,' . $matiere->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $matiere->update($validated);

        return redirect()->route('gestion-matieres.index')->with('success', 'Matière modifiée avec succès.');
    }

    public function destroy(Matiere $matiere)
    {
        $matiere->delete();
        return redirect()->route('gestion-matieres.index')->with('success', 'Matière supprimée avec succès.');
    }
}
