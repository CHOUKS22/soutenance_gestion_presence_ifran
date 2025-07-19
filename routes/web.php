<?php

// Contrôleurs principaux
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\CoordinateurController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\DashboardController;


// Contrôleurs Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GestionEtudiantController;
use App\Http\Controllers\Admin\GestionParentController;
use App\Http\Controllers\Admin\GestionProfesseurController;
use App\Http\Controllers\Admin\GestionCoordinateurController;
use App\Http\Controllers\Admin\GestionAdminController;
use App\Http\Controllers\Admin\GestionMatiereController;
use App\Http\Controllers\Admin\GestionClasseController;
use App\Http\Controllers\Admin\GestionAnneeAcademiqueController;
use App\Http\Controllers\Admin\GestionTypeSeanceController;
use App\Http\Controllers\Admin\GestionSemestreController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Route de debug pour vérifier l'utilisateur connecté
// Route::get('/debug-user', function () {
//     $user = Auth::user();

//     if (!$user) {
//         return response()->json(['error' => 'Utilisateur non connecté']);
//     }

//     return response()->json([
//         'user_id' => $user->id,
//         'email' => $user->email,
//         'role_id' => $user->role_id,
//         'role' => $user->role ? $user->role->nom : null,
//         'role_raw' => $user->role ? $user->role->toArray() : null,
//     ]);
// })->middleware('auth');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboards par rôle avec middleware spécifique
    Route::middleware(['Etudiant'])->group(function () {
        Route::get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
    });

    Route::middleware(['Professeur'])->group(function () {
        Route::get('/professeur/dashboard', [ProfesseurController::class, 'dashboard'])->name('professeur.dashboard');
    });

    Route::middleware(['Coordinateur'])->group(function () {
        Route::get('/coordinateur/dashboard', [CoordinateurController::class, 'dashboard'])->name('coordinateur.dashboard');
        Route::resource('seances', SeanceController::class);
    });

    Route::middleware(['Parent'])->group(function () {
        Route::get('/parent/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');
    });

    Route::middleware(['Administrateur'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('admins', AdminController::class);
        Route::resource('users', UserController::class);
        Route::resource('gestion-etudiants', GestionEtudiantController::class);
        Route::resource('gestion-parents', GestionParentController::class);
        Route::resource('gestion-professeurs', GestionProfesseurController::class);
        Route::resource('gestion-coordinateurs', GestionCoordinateurController::class);
        Route::resource('gestion-admins', GestionAdminController::class);
        Route::resource('gestion-matieres', GestionMatiereController::class);
        Route::resource('gestion-classes', GestionClasseController::class);
        Route::resource('gestion-annees-academiques', GestionAnneeAcademiqueController::class);
        Route::resource('gestion-types-seances', GestionTypeSeanceController::class);
        Route::resource('gestion-semestres', GestionSemestreController::class);

        // Routes pour l'assignation d'étudiants aux parents
        Route::post('/gestion-parents/assign-etudiant', [GestionParentController::class, 'assignEtudiant'])->name('gestion-parents.assign-etudiant');
        Route::post('/gestion-parents/unassign-etudiant', [GestionParentController::class, 'unassignEtudiant'])->name('gestion-parents.unassign-etudiant');

        // Routes admin (nécessitent le rôle admin)

    });    // Routes de profil (accessible à tous les utilisateurs connectés)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
