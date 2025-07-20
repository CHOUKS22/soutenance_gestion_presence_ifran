<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class GestionRoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->orderBy('created_at', 'desc')->get();
        return view('admin.roles.roles', compact('roles'));
    }

    public function show(Role $gestionRole)
    {
        $gestionRole->load('users');
        return view('admin.roles.role-show', ['role' => $gestionRole]);
    }

    public function create()
    {
        return view('admin.roles.role-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:roles',
            'description' => 'required|string|max:1000',
        ]);

        Role::create($validated);

        return redirect()->route('gestion-roles.index')->with('success', 'Rôle créé avec succès.');
    }

    public function edit(Role $gestionRole)
    {
        return view('admin.roles.role-edit', ['role' => $gestionRole]);
    }

    public function update(Request $request, Role $gestionRole)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:roles,nom,' . $gestionRole->id,
            'description' => 'required|string|max:1000',
        ]);

        $gestionRole->update($validated);

        return redirect()->route('gestion-roles.index')->with('success', 'Rôle modifié avec succès.');
    }

    public function destroy(Role $gestionRole)
    {
        // Vérifier si le rôle est utilisé
        if ($gestionRole->users()->count() > 0) {
            return redirect()->route('gestion-roles.index')->with('error', 'Impossible de supprimer ce rôle car il est utilisé par des utilisateurs.');
        }

        $gestionRole->delete();
        return redirect()->route('gestion-roles.index')->with('success', 'Rôle supprimé avec succès.');
    }
}
