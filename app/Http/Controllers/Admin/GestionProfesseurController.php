<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professeur;
use App\Models\Role;
use App\Models\User;
use App\Models\Filliere;
use Illuminate\Http\Request;

class GestionProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professeurs = Professeur::with(['user', 'filliere'])->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Professeur" qui n'ont pas encore d'infos professeur
        $roleProfesseur = Role::where('nom', 'Professeur')->first();
        $usersProfesseurs = [];

        if ($roleProfesseur) {
            $usersProfesseurs = User::where('role_id', $roleProfesseur->id)
                ->whereNotIn('id', Professeur::pluck('user_id'))
                ->get();
        }

        // Récupérer toutes les filières pour l'assignation
        $fillieres = Filliere::all();

        return view('admin.professeurs.professeur', compact('professeurs', 'usersProfesseurs', 'fillieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professeurs = Professeur::with(['user', 'filliere'])->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Professeur" qui n'ont pas encore d'infos professeur
        $roleProfesseur = Role::where('nom', 'Professeur')->first();
        $usersProfesseurs = [];

        if ($roleProfesseur) {
            $usersProfesseurs = User::where('role_id', $roleProfesseur->id)
                ->whereNotIn('id', Professeur::pluck('user_id'))
                ->get();
        }

        // Récupérer toutes les filières pour l'assignation
        $fillieres = Filliere::all();

        return view('admin.professeurs.professeur', compact('professeurs', 'usersProfesseurs', 'fillieres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'filliere_id' => 'required|exists:fillieres,id',
        ]);

        // Vérifier que l'utilisateur n'a pas déjà des infos professeur
        $existingProfesseur = Professeur::where('user_id', $request->user_id)->first();
        if ($existingProfesseur) {
            return redirect()->back()->with('error', 'Cet utilisateur a déjà des informations de professeur.');
        }

        // Créer le professeur
        Professeur::create([
            'user_id' => $request->user_id,
            'filliere_id' => $request->filliere_id,
        ]);

        return redirect()->route('gestion-professeurs.index')->with('success', 'Informations du professeur créées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Professeur $gestion_professeur)
    {
        $professeur = $gestion_professeur->load(['user.role', 'filliere']);
        return view('admin.professeurs.professeur-show', compact('professeur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professeur $gestion_professeur)
    {
        $professeur = $gestion_professeur->load(['user.role', 'filliere']);
        $fillieres = Filliere::all();
        return view('admin.professeurs.professeur-edit', compact('professeur', 'fillieres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professeur $gestion_professeur)
    {
        $request->validate([
            'filliere_id' => 'required|exists:fillieres,id',
        ]);

        // Mettre à jour les informations spécifiques au professeur
        $gestion_professeur->update([
            'filliere_id' => $request->filliere_id,
        ]);

        return redirect()->route('gestion-professeurs.show', $gestion_professeur)->with('success', 'Informations du professeur modifiées avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professeur $gestion_professeur)
    {
        // Supprimer seulement les informations spécifiques au professeur
        // L'utilisateur reste intact
        $gestion_professeur->delete();

        return redirect()->route('gestion-professeurs.index')->with('success', 'Informations du professeur supprimées avec succès.');
    }
}
