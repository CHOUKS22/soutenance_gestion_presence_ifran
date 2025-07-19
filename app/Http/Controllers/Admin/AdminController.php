<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Dashboard pour les admins
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Récupérer toutes les données nécessaires pour le dashboard admin
        $users = User::with('role')->orderBy('created_at', 'desc')->paginate(10);
        $totalUsers = User::count();
        $totalEtudiants = User::whereHas('role', function($query) {
            $query->where('nom', 'Etudiant');
        })->count();
        $totalProfesseurs = User::whereHas('role', function($query) {
            $query->where('nom', 'Professeur');
        })->count();
        $totalCoordinateurs = User::whereHas('role', function($query) {
            $query->where('nom', 'Coordinateur');
        })->count();
        $totalParents = User::whereHas('role', function($query) {
            $query->where('nom', 'Parent');
        })->count();

        // Données pour les séances
        $seances = Seance::with(['classe', 'matiere', 'professeur'])->orderBy('date_debut', 'desc')->get();
        $totalSeances = Seance::count();

        return view('admin.dashboard', compact(
            'user',
            'users',
            'totalUsers',
            'totalEtudiants',
            'totalProfesseurs',
            'totalCoordinateurs',
            'totalParents',
            'seances',
            'totalSeances'
        ));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
