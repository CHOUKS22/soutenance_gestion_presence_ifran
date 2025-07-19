<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parent_model;
use App\Models\Role;
use App\Models\User;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class GestionParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = Parent_model::with(['user', 'etudiants.user'])->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Parent" qui n'ont pas encore d'infos parent
        $roleParent = Role::where('nom', 'Parent')->first();
        $usersParents = [];

        if ($roleParent) {
            $usersParents = User::where('role_id', $roleParent->id)
                ->whereNotIn('id', Parent_model::pluck('user_id'))
                ->get();
        }

        // Récupérer tous les étudiants pour l'assignation
        $etudiants = Etudiant::with('user')->get();

        return view('admin.parents.parent', compact('parents', 'usersParents', 'etudiants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Parent_model::with(['user', 'etudiants.user'])->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Parent" qui n'ont pas encore d'infos parent
        $roleParent = Role::where('nom', 'Parent')->first();
        $usersParents = [];

        if ($roleParent) {
            $usersParents = User::where('role_id', $roleParent->id)
                ->whereNotIn('id', Parent_model::pluck('user_id'))
                ->get();
        }

        // Récupérer tous les étudiants pour l'assignation
        $etudiants = Etudiant::with('user')->get();

        return view('admin.parents.parent', compact('parents', 'usersParents', 'etudiants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'telephone' => 'required|string|max:20',
            'type_relation' => 'required|in:Pére,Mére,garant,Tuteur,Autre',
        ]);

        // Vérifier que l'utilisateur n'a pas déjà des infos parent
        $existingParent = Parent_model::where('user_id', $request->user_id)->first();
        if ($existingParent) {
            return redirect()->back()->with('error', 'Cet utilisateur a déjà des informations de parent.');
        }

        // Créer le parent
        Parent_model::create([
            'user_id' => $request->user_id,
            'telephone' => $request->telephone,
            'type_relation' => $request->type_relation,
        ]);

        return redirect()->route('gestion-parents.index')->with('success', 'Informations du parent créées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Parent_model $gestion_parent)
    {
        $parent = $gestion_parent->load(['user.role', 'etudiants.user']);
        return view('admin.parents.parent-show', compact('parent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parent_model $gestion_parent)
    {
        $parent = $gestion_parent->load('user.role');
        return view('admin.parents.parent-edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parent_model $gestion_parent)
    {
        $request->validate([
            'telephone' => 'required|string|max:20',
            'type_relation' => 'required|in:Pére,Mére,garant,Tuteur,Autre',
        ]);

        // Mettre à jour les informations spécifiques au parent
        $gestion_parent->update([
            'telephone' => $request->telephone,
            'type_relation' => $request->type_relation,
        ]);

        return redirect()->route('gestion-parents.show', $gestion_parent)->with('success', 'Informations du parent modifiées avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parent_model $gestion_parent)
    {
        // Supprimer seulement les informations spécifiques au parent
        // L'utilisateur reste intact
        $gestion_parent->delete();

        return redirect()->route('gestion-parents.index')->with('success', 'Informations du parent supprimées avec succès.');
    }

    /**
     * Assigner un étudiant à un parent
     */
    public function assignEtudiant(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'etudiant_id' => 'required|exists:etudiants,id',
        ]);

        $parent = Parent_model::find($request->parent_id);
        $etudiant = Etudiant::find($request->etudiant_id);

        // Vérifier si l'assignation existe déjà
        if ($parent->etudiants()->where('etudiant_id', $etudiant->id)->exists()) {
            return redirect()->back()->with('error', 'Cet étudiant est déjà assigné à ce parent.');
        }

        // Assigner l'étudiant au parent
        $parent->etudiants()->attach($etudiant->id);

        return redirect()->back()->with('success', 'Étudiant assigné avec succès au parent.');
    }

    /**
     * Désassigner un étudiant d'un parent
     */
    public function unassignEtudiant(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'etudiant_id' => 'required|exists:etudiants,id',
        ]);

        $parent = Parent_model::find($request->parent_id);
        $etudiant = Etudiant::find($request->etudiant_id);

        // Désassigner l'étudiant du parent
        $parent->etudiants()->detach($etudiant->id);

        return redirect()->back()->with('success', 'Étudiant désassigné avec succès du parent.');
    }
}
