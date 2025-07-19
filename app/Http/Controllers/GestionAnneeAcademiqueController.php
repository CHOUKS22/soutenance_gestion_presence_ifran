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
        return view('admin.annees-academiques', compact('annees_academiques'));
    }

    public function show(Annee_academique $annee_academique)
    {
        return view('admin.annee-academique-show', compact('annee_academique'));
    }

    public function create()
    {
        return view('admin.annee-academique-create');
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

    public function edit(Annee_academique $annee_academique)
    {
        return view('admin.annee-academique-edit', compact('annee_academique'));
    }

    public function update(Request $request, Annee_academique $annee_academique)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:annees_academiques,libelle,' . $annee_academique->id,
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $annee_academique->update($validated);

        return redirect()->route('gestion-annees-academiques.index')->with('success', 'Année académique modifiée avec succès.');
    }

    public function destroy(Annee_academique $annee_academique)
    {
        $annee_academique->delete();
        return redirect()->route('gestion-annees-academiques.index')->with('success', 'Année académique supprimée avec succès.');
    }
}
