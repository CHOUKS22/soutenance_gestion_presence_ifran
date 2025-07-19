<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class GestionAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with(['user'])->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Administrateur" qui n'ont pas encore d'infos admin
        $roleAdmin = Role::where('nom', 'Administrateur')->first();
        $usersAdmins = [];

        if ($roleAdmin) {
            $usersAdmins = User::where('role_id', $roleAdmin->id)
                ->whereNotIn('id', Admin::pluck('user_id'))
                ->get();
        }

        return view('admin.admins.admin', compact('admins', 'usersAdmins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admins = Admin::with(['user'])->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les utilisateurs avec le rôle "Administrateur" qui n'ont pas encore d'infos admin
        $roleAdmin = Role::where('nom', 'Administrateur')->first();
        $usersAdmins = [];

        if ($roleAdmin) {
            $usersAdmins = User::where('role_id', $roleAdmin->id)
                ->whereNotIn('id', Admin::pluck('user_id'))
                ->get();
        }

        return view('admin.admins.admin', compact('admins', 'usersAdmins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:super admin,admin',
        ]);

        // Vérifier que l'utilisateur n'a pas déjà des infos admin
        $existingAdmin = Admin::where('user_id', $request->user_id)->first();
        if ($existingAdmin) {
            return redirect()->back()->with('error', 'Cet utilisateur a déjà des informations d\'admin.');
        }

        // Créer l'admin
        Admin::create([
            'user_id' => $request->user_id,
            'role' => $request->role,
        ]);

        return redirect()->route('gestion-admins.index')->with('success', 'Informations de l\'admin créées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $gestion_admin)
    {
        $admin = $gestion_admin->load(['user.role']);
        return view('admin.admins.admin-show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $gestion_admin)
    {
        $admin = $gestion_admin->load(['user.role']);
        return view('admin.admins.admin-edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $gestion_admin)
    {
        $request->validate([
            'role' => 'required|in:super admin,admin',
        ]);

        // Mettre à jour les informations spécifiques à l'admin
        $gestion_admin->update([
            'role' => $request->role,
        ]);

        return redirect()->route('gestion-admins.show', $gestion_admin)->with('success', 'Informations de l\'admin modifiées avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $gestion_admin)
    {
        // Supprimer seulement les informations spécifiques à l'admin
        // L'utilisateur reste intact
        $gestion_admin->delete();

        return redirect()->route('gestion-admins.index')->with('success', 'Informations de l\'admin supprimées avec succès.');
    }
}
