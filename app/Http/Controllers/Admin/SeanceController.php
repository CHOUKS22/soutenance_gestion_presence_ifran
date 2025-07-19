<?php
namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Statut_seance;
use App\Models\Semestre;
use App\Models\Type_seance;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seances = Seance::with(['classe', 'matiere', 'professeur', 'statutSeance', 'semestre', 'typeSeance'])
                          ->orderBy('date_debut', 'desc')
                          ->paginate(10);
        return view('coordinateur.seances.seances', compact('seances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $professeurs = Professeur::all();
        $statuts = Statut_seance::all();
        $semestres = Semestre::all();
        $types = Type_seance::all();

        return view('coordinateur.seances.seance-create', compact('classes', 'matieres', 'professeurs', 'statuts', 'semestres', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matieres_id' => 'required|exists:matieres,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'statut_seance_id' => 'required|exists:statuts_seances,id',
            'semestre_id' => 'required|exists:semestres,id',
            'type_seance_id' => 'required|exists:types_seances,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        Seance::create($request->all());

        return redirect()->route('seances.index')->with('success', 'Séance créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Seance $seance)
    {
        $seance->load(['classe', 'matiere', 'professeur', 'statutSeance', 'semestre', 'typeSeance']);
        return view('coordinateur.seances.seance-show', compact('seance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seance $seance)
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $professeurs = Professeur::all();
        $statuts = Statut_seance::all();
        $semestres = Semestre::all();
        $types = Type_seance::all();

        return view('coordinateur.seances.seance-edit', compact('seance', 'classes', 'matieres', 'professeurs', 'statuts', 'semestres', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seance $seance)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matieres_id' => 'required|exists:matieres,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'statut_seance_id' => 'required|exists:statuts_seances,id',
            'semestre_id' => 'required|exists:semestres,id',
            'type_seance_id' => 'required|exists:types_seances,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $seance->update($request->all());

        return redirect()->route('seances.index')->with('success', 'Séance mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seance $seance)
    {
        $seance->delete();
        return redirect()->route('seances.index')->with('success', 'Séance supprimée avec succès.');
    }
}
