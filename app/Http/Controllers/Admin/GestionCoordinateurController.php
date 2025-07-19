<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coordinateur;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class GestionCoordinateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coordinateurs = Coordinateur::with(['user'])->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Coordinateur" qui n'ont pas encore d'infos coordinateur
        $roleCoordinateur = Role::where('nom', 'Coordinateur')->first();
        $usersCoordinateurs = [];

        if ($roleCoordinateur) {
            $usersCoordinateurs = User::where('role_id', $roleCoordinateur->id)
                ->whereNotIn('id', Coordinateur::pluck('user_id'))
                ->get();
        }

        return view('admin.coordinateurs.coordinateur', compact('coordinateurs', 'usersCoordinateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coordinateurs = Coordinateur::with(['user'])->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Coordinateur" qui n'ont pas encore d'infos coordinateur
        $roleCoordinateur = Role::where('nom', 'Coordinateur')->first();
        $usersCoordinateurs = [];

        if ($roleCoordinateur) {
            $usersCoordinateurs = User::where('role_id', $roleCoordinateur->id)
                ->whereNotIn('id', Coordinateur::pluck('user_id'))
                ->get();
        }

        return view('admin.coordinateurs.coordinateur', compact('coordinateurs', 'usersCoordinateurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:coordinateur pédagogique,coordinateur de filière',
        ]);

        // Vérifier que l'utilisateur n'a pas déjà des infos coordinateur
        $existingCoordinateur = Coordinateur::where('user_id', $request->user_id)->first();
        if ($existingCoordinateur) {
            return redirect()->back()->with('error', 'Cet utilisateur a déjà des informations de coordinateur.');
        }

        // Créer le coordinateur
        Coordinateur::create([
            'user_id' => $request->user_id,
            'role' => $request->role,
        ]);

        return redirect()->route('gestion-coordinateurs.index')->with('success', 'Informations du coordinateur créées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coordinateur $gestion_coordinateur)
    {
        $coordinateur = $gestion_coordinateur->load(['user.role']);
        return view('admin.coordinateurs.coordinateur-show', compact('coordinateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coordinateur $gestion_coordinateur)
    {
        $coordinateur = $gestion_coordinateur->load(['user.role']);
        return view('admin.coordinateurs.coordinateur-edit', compact('coordinateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coordinateur $gestion_coordinateur)
    {
        $request->validate([
            'role' => 'required|in:coordinateur pédagogique,coordinateur de filière',
        ]);

        // Mettre à jour les informations spécifiques au coordinateur
        $gestion_coordinateur->update([
            'role' => $request->role,
        ]);

        return redirect()->route('gestion-coordinateurs.show', $gestion_coordinateur)->with('success', 'Informations du coordinateur modifiées avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coordinateur $gestion_coordinateur)
    {
        // Supprimer seulement les informations spécifiques au coordinateur
        // L'utilisateur reste intact
        $gestion_coordinateur->delete();

        return redirect()->route('gestion-coordinateurs.index')->with('success', 'Informations du coordinateur supprimées avec succès.');
    }
}
