<?php

// Contrôleurs principaux
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\CoordinateurController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\DashboardController;

//Controlleurs Coordinateur
use App\Http\Controllers\Coordinateur\SeanceController;
use App\Http\Controllers\Coordinateur\DashboardCoordinateurController;
use App\Http\Controllers\Coordinateur\GestionMatiereController;
// Contrôleurs Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GestionEtudiantController;
use App\Http\Controllers\Admin\GestionParentController;
use App\Http\Controllers\Admin\GestionProfesseurController;
use App\Http\Controllers\Admin\GestionCoordinateurController;
use App\Http\Controllers\Admin\GestionAdminController;
use App\Http\Controllers\Admin\GestionClasseController;
use App\Http\Controllers\Admin\GestionAnneeAcademiqueController;
use App\Http\Controllers\Admin\GestionTypeSeanceController;
use App\Http\Controllers\Admin\GestionSemestreController;
use App\Http\Controllers\Admin\GestionRoleController;
use App\Http\Controllers\Admin\GestionStatutSeanceController;
use App\Http\Controllers\Admin\GestionStatutPresenceController;
use App\Http\Controllers\Admin\GestionAnneeClasseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


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
        Route::get('/coordinateur/dashboard', [DashboardCoordinateurController::class, 'index'])->name('coordinateur.dashboard');
        Route::resource('gestion-seances', SeanceController::class);
        Route::resource('matieres', GestionMatiereController::class);

        // Routes supplémentaires pour les séances
        Route::get('/seances/prochaines', [SeanceController::class, 'prochaines'])->name('seances.prochaines');
        Route::get('/seances/historique', [SeanceController::class, 'historique'])->name('seances.historique');
        Route::get('/seances/aujourd-hui', [SeanceController::class, 'aujourdhui'])->name('seances.aujourdhui');
        Route::get('/seances/cette-semaine', [SeanceController::class, 'cetteSemaine'])->name('seances.cette-semaine');
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
        Route::resource('gestion-classes', GestionClasseController::class);
        Route::resource('gestion-annees-academiques', GestionAnneeAcademiqueController::class);
        Route::resource('gestion-types-seances', GestionTypeSeanceController::class);
        Route::resource('gestion-semestres', GestionSemestreController::class);
        Route::resource('gestion-roles', GestionRoleController::class);
        Route::resource('gestion-statuts-seances', GestionStatutSeanceController::class);
        Route::resource('gestion-statuts-presences', GestionStatutPresenceController::class);
        Route::resource('gestion-annees-classes', GestionAnneeClasseController::class);
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
