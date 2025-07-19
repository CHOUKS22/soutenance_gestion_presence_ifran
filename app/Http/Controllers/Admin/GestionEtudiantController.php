<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class GestionEtudiantController extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etudiants = Etudiant::with('user')->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Etudiant" qui n'ont pas encore d'infos étudiant
        $roleEtudiant = Role::where('nom', 'Etudiant')->first();
        $usersEtudiants = [];

        if ($roleEtudiant) {
            $usersEtudiants = User::where('role_id', $roleEtudiant->id)
                ->whereNotIn('id', Etudiant::pluck('user_id'))
                ->get();
        }

        return view('admin.etudiants.etudiant', compact('etudiants', 'usersEtudiants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etudiants = Etudiant::with('user')->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Etudiant" qui n'ont pas encore d'infos étudiant
        $roleEtudiant = Role::where('nom', 'Etudiant')->first();
        $usersEtudiants = [];

        if ($roleEtudiant) {
            $usersEtudiants = User::where('role_id', $roleEtudiant->id)
                ->whereNotIn('id', Etudiant::pluck('user_id'))
                ->get();
        }

        return view('admin.etudiants.etudiant', compact('etudiants', 'usersEtudiants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ]);

        // Vérifier que l'utilisateur a bien le rôle "Etudiant"
        $roleEtudiant = Role::where('nom', 'Etudiant')->first();
        if (!$roleEtudiant) {
            return redirect()->back()->with('error', 'Le rôle étudiant n\'existe pas.');
        }

        $user = User::find($request->user_id);
        if (!$user || $user->role_id !== $roleEtudiant->id) {
            return redirect()->back()->with('error', 'L\'utilisateur sélectionné n\'est pas un étudiant.');
        }

        // Vérifier que cet étudiant n'existe pas déjà
        $etudiantExistant = Etudiant::where('user_id', $request->user_id)->first();
        if ($etudiantExistant) {
            return redirect()->back()->with('error', 'Les informations de cet étudiant ont déjà été créées.');
        }

        // Créer l'étudiant
        Etudiant::create([
            'user_id' => $request->user_id,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Informations de l\'étudiant créées avec succès.');
    }    /**
     * Display the specified resource.
     */
    public function show(Etudiant $gestion_etudiant)
    {
        $etudiant = $gestion_etudiant->load('user.role');
        return view('admin.etudiants.etudiant-show', compact('etudiant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etudiant $gestion_etudiant)
    {
        $etudiant = $gestion_etudiant->load('user.role');
        return view('admin.etudiants.etudiant-edit', compact('etudiant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etudiant $gestion_etudiant)
    {
        $request->validate([
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ]);

        // Mettre à jour les informations spécifiques à l'étudiant
        $gestion_etudiant->update([
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('gestion-etudiants.index')->with('success', 'Informations de l\'étudiant modifiées avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etudiant $gestion_etudiant)
    {
        // Supprimer seulement les informations spécifiques à l'étudiant
        // L'utilisateur reste intact
        $gestion_etudiant->delete();

        return redirect()->route('gestion-etudiants.index')->with('success', 'Informations de l\'étudiant supprimées avec succès.');
    }
}


