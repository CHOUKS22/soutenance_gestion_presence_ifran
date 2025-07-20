<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnneeClasse;
use App\Models\Annee_academique;
use App\Models\Classe;
use App\Models\Coordinateur;
use Illuminate\Http\Request;

class GestionAnneeClasseController extends Controller
{
    public function index()
    {
        $anneesClasses = AnneeClasse::with(['anneeAcademique', 'classe', 'coordinateur.user', 'etudiants'])
            ->orderBy('created_at', 'desc')->get();
        return view('admin.annees-classes.annees-classes', compact('anneesClasses'));
    }

    public function show(AnneeClasse $gestionAnneeClasse)
    {
        $gestionAnneeClasse->load(['anneeAcademique', 'classe', 'coordinateur.user', 'etudiants']);
        return view('admin.annees-classes.annee-classe-show', ['anneeClasse' => $gestionAnneeClasse]);
    }

    public function create()
    {
        $anneesAcademiques = Annee_academique::orderBy('libelle', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $coordinateurs = Coordinateur::with('user')->get();

        return view('admin.annees-classes.annee-classe-create', compact('anneesAcademiques', 'classes', 'coordinateurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'classe_id' => 'required|exists:classes,id',
            'coordinateur_id' => 'required|exists:coordinateurs,id',
        ]);

        // Vérifier l'unicité de la combinaison année-classe
        $exists = AnneeClasse::where('annee_academique_id', $validated['annee_academique_id'])
            ->where('classe_id', $validated['classe_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['classe_id' => 'Cette classe est déjà associée à cette année académique.'])->withInput();
        }

        AnneeClasse::create($validated);

        return redirect()->route('gestion-annees-classes.index')->with('success', 'Association année-classe créée avec succès.');
    }

    public function edit(AnneeClasse $gestionAnneeClasse)
    {
        $anneesAcademiques = Annee_academique::orderBy('libelle', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $coordinateurs = Coordinateur::with('user')->get();

        return view('admin.annees-classes.annee-classe-edit', [
            'anneeClasse' => $gestionAnneeClasse,
            'anneesAcademiques' => $anneesAcademiques,
            'classes' => $classes,
            'coordinateurs' => $coordinateurs
        ]);
    }

    public function update(Request $request, AnneeClasse $gestionAnneeClasse)
    {
        $validated = $request->validate([
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'classe_id' => 'required|exists:classes,id',
            'coordinateur_id' => 'required|exists:coordinateurs,id',
        ]);

        // Vérifier l'unicité de la combinaison année-classe (sauf pour l'enregistrement actuel)
        $exists = AnneeClasse::where('annee_academique_id', $validated['annee_academique_id'])
            ->where('classe_id', $validated['classe_id'])
            ->where('id', '!=', $gestionAnneeClasse->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['classe_id' => 'Cette classe est déjà associée à cette année académique.'])->withInput();
        }

        $gestionAnneeClasse->update($validated);

        return redirect()->route('gestion-annees-classes.index')->with('success', 'Association année-classe modifiée avec succès.');
    }

    public function destroy(AnneeClasse $gestionAnneeClasse)
    {
        // Vérifier s'il y a des étudiants associés
        if ($gestionAnneeClasse->etudiants()->count() > 0) {
            return redirect()->route('gestion-annees-classes.index')->with('error', 'Impossible de supprimer cette association car elle contient des étudiants.');
        }

        $gestionAnneeClasse->delete();
        return redirect()->route('gestion-annees-classes.index')->with('success', 'Association année-classe supprimée avec succès.');
    }
}
