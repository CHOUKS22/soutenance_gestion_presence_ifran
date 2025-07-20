<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semestre;
use App\Models\Annee_academique;
use Illuminate\Http\Request;

class GestionSemestreController extends Controller
{
    public function index()
    {
        $semestres = Semestre::with('anneeAcademique')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.semestres.semestres', compact('semestres'));
    }

    public function show(Semestre $semestre)
    {
        $semestre->load('anneeAcademique');
        return view('admin.semestres.semestre-show', compact('semestre'));
    }

    public function create()
    {
        $annees_academiques = Annee_academique::all();
        return view('admin.semestres.semestre-create', compact('annees_academiques'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'libelle' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        Semestre::create($validated);

        return redirect()->route('gestion-semestres.index')->with('success', 'Semestre créé avec succès.');
    }

    public function edit(Semestre $semestre)
    {
        $annees_academiques = Annee_academique::all();
        return view('admin.semestres.semestre-edit', compact('semestre', 'annees_academiques'));
    }

    public function update(Request $request, Semestre $semestre)
    {
        $validated = $request->validate([
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'libelle' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $semestre->update($validated);

        return redirect()->route('gestion-semestres.index')->with('success', 'Semestre modifié avec succès.');
    }

    public function destroy(Semestre $semestre)
    {
        $semestre->delete();
        return redirect()->route('gestion-semestres.index')->with('success', 'Semestre supprimé avec succès.');
    }
}
