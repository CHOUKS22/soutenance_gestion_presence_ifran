<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statut_seance;
use Illuminate\Http\Request;

class GestionStatutSeanceController extends Controller
{
    public function index()
    {
        $statutsSeances = Statut_seance::withCount('seances')->orderBy('created_at', 'desc')->get();
        return view('admin.statuts-seances.statuts-seances', compact('statutsSeances'));
    }

    public function show(Statut_seance $gestionStatutSeance)
    {
        $gestionStatutSeance->load('seances');
        return view('admin.statuts-seances.statut-seance-show', ['statutSeance' => $gestionStatutSeance]);
    }

    public function create()
    {
        return view('admin.statuts-seances.statut-seance-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:statuts_seances',
            'description' => 'nullable|string|max:1000',
        ]);

        Statut_seance::create($validated);

        return redirect()->route('gestion-statuts-seances.index')->with('success', 'Statut de séance créé avec succès.');
    }

    public function edit(Statut_seance $gestionStatutSeance)
    {
        return view('admin.statuts-seances.statut-seance-edit', ['statutSeance' => $gestionStatutSeance]);
    }

    public function update(Request $request, Statut_seance $gestionStatutSeance)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:statuts_seances,libelle,' . $gestionStatutSeance->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $gestionStatutSeance->update($validated);

        return redirect()->route('gestion-statuts-seances.index')->with('success', 'Statut de séance modifié avec succès.');
    }

    public function destroy(Statut_seance $gestionStatutSeance)
    {
        // Vérifier si le statut est utilisé
        if ($gestionStatutSeance->seances()->count() > 0) {
            return redirect()->route('gestion-statuts-seances.index')->with('error', 'Impossible de supprimer ce statut car il est utilisé par des séances.');
        }

        $gestionStatutSeance->delete();
        return redirect()->route('gestion-statuts-seances.index')->with('success', 'Statut de séance supprimé avec succès.');
    }
}
