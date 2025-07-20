<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatutPresence;
use Illuminate\Http\Request;

class GestionStatutPresenceController extends Controller
{
    public function index()
    {
        $statutsPresences = StatutPresence::withCount('presences')->orderBy('created_at', 'desc')->get();
        return view('admin.statuts-presences.statuts-presences', compact('statutsPresences'));
    }

    public function show(StatutPresence $gestionStatutPresence)
    {
        $gestionStatutPresence->load('presences');
        return view('admin.statuts-presences.statut-presence-show', ['statutPresence' => $gestionStatutPresence]);
    }

    public function create()
    {
        return view('admin.statuts-presences.statut-presence-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:statuts_presences',
            'description' => 'nullable|string|max:1000',
        ]);

        StatutPresence::create($validated);

        return redirect()->route('gestion-statuts-presences.index')->with('success', 'Statut de présence créé avec succès.');
    }

    public function edit(StatutPresence $gestionStatutPresence)
    {
        return view('admin.statuts-presences.statut-presence-edit', ['statutPresence' => $gestionStatutPresence]);
    }

    public function update(Request $request, StatutPresence $gestionStatutPresence)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:statuts_presences,libelle,' . $gestionStatutPresence->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $gestionStatutPresence->update($validated);

        return redirect()->route('gestion-statuts-presences.index')->with('success', 'Statut de présence modifié avec succès.');
    }

    public function destroy(StatutPresence $gestionStatutPresence)
    {
        // Vérifier si le statut est utilisé
        if ($gestionStatutPresence->presences()->count() > 0) {
            return redirect()->route('gestion-statuts-presences.index')->with('error', 'Impossible de supprimer ce statut car il est utilisé par des présences.');
        }

        $gestionStatutPresence->delete();
        return redirect()->route('gestion-statuts-presences.index')->with('success', 'Statut de présence supprimé avec succès.');
    }
}
