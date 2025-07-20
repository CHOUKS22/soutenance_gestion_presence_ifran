<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annee_academique;
use Illuminate\Http\Request;

class GestionAnneeAcademiqueController extends Controller
{
    public function index()
    {
        $annees_academiques = Annee_academique::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.annees-academiques.annees-academiques', compact('annees_academiques'));
    }

    public function show(Annee_academique $gestion_annees_academique)
    {
        $gestion_annees_academique->load(['semestres', 'anneesClasses']);
        return view('admin.annees-academiques.annee-academique-show', ['annee_academique' => $gestion_annees_academique]);
    }

    public function create()
    {
        return view('admin.annees-academiques.annee-academique-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:annees_academiques',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        Annee_academique::create($validated);

        return redirect()->route('gestion-annees-academiques.index')->with('success', 'Année académique créée avec succès.');
    }

    public function edit(Annee_academique $gestion_annees_academique)
    {
        $gestion_annees_academique->load(['semestres', 'anneesClasses']);
        return view('admin.annees-academiques.annee-academique-edit', ['annee_academique' => $gestion_annees_academique]);
    }

    public function update(Request $request, Annee_academique $gestion_annees_academique)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:annees_academiques,libelle,' . $gestion_annees_academique->id,
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $gestion_annees_academique->update($validated);

        return redirect()->route('gestion-annees-academiques.index')->with('success', 'Année académique modifiée avec succès.');
    }

    public function destroy(Annee_academique $gestion_annees_academique)
    {
        $gestion_annees_academique->delete();
        return redirect()->route('gestion-annees-academiques.index')->with('success', 'Année académique supprimée avec succès.');
    }
}
