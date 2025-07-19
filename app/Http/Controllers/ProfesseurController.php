<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesseurController extends Controller
{
    /**
     * Dashboard pour les professeurs
     */
    // // public function dashboard()
    // // {
    // //     $user = Auth::user();
    // //     return view('professeur.dashboard', compact('user'));
    // }

    /**
     * Affiche la liste des professeurs.
     */
    public function index()
    {
        $professeurs = Professeur::with('user')->get();
        return view('dashboard', compact('professeurs'));
    }

    /**
     * Affiche le formulaire de création d’un professeur.
     */
    public function create()
    {
        // On cherche tous les users qui ne sont pas déjà professeurs
        $users = User::whereDoesntHave('professeur')->get();
        return view('dashboard', compact('users'));
    }

    /**
     * Enregistre un nouveau professeur (pour un utilisateur existant).
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:professeurs,user_id',

            // Ajoute ici d'autres règles selon tes champs
        ]);

        Professeur::create([
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Professeur ajouté avec succès.');
    }

    /**
     * Affiche la fiche d’un professeur.
     */
    public function show($id)
    {
        $professeur = Professeur::with('user')->findOrFail($id);
        return view('professeurs.show', compact('professeur'));
    }

    /**
     * Affiche le formulaire d’édition.
     */
    public function edit($id)
    {
        $professeur = Professeur::findOrFail($id);
        $users = User::all();
        return view('professeurs.edit', compact('professeur', 'users'));
    }

    /**
     * Met à jour les informations d’un professeur.
     */
    public function update(Request $request, $id)
    {
        $professeur = Professeur::findOrFail($id);

        return redirect()->route('dashboard')
            ->with('success', 'Professeur mis à jour avec succès.');
    }

    /**
     * Supprime un professeur.
     */
    public function destroy($id)
    {
        $professeur = Professeur::findOrFail($id);
        $professeur->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Professeur supprimé avec succès.');
    }
}
