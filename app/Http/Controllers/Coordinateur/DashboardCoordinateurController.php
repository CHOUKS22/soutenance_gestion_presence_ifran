<?php

namespace App\Http\Controllers\Coordinateur;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardCoordinateurController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistiques générales
        $totalMatieres = Matiere::count();
        $totalSeances = Seance::count();
        $totalClasses = Classe::count();
        $totalEtudiants = Etudiant::count();

        // Séances d'aujourd'hui
        $seancesAujourdhui = Seance::whereDate('date_debut', Carbon::today())
            ->with(['classe', 'matiere', 'professeur'])
            ->orderBy('date_debut')
            ->get();

        // Prochaines séances (7 prochains jours)
        $prochainesSeances = Seance::whereBetween('date_debut', [
                Carbon::tomorrow(),
                Carbon::today()->addDays(7)
            ])
            ->with(['classe', 'matiere', 'professeur'])
            ->orderBy('date_debut')
            ->limit(5)
            ->get();

        // Séances récentes
        $seancesRecentes = Seance::with(['classe', 'matiere', 'professeur'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Matières récemment créées
        $matieresRecentes = Matiere::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Taux de présence global (approximatif)
        $totalPresences = Presence::count();
        $presencesMarquees = 0;

        // Sécurité pour éviter les erreurs si la table StatutPresence est vide
        try {
            $presencesMarquees = Presence::whereHas('statutPresence', function($query) {
                $query->where('libelle', 'like', '%Présent%');
            })->count();
        } catch (\Exception $e) {
            // En cas d'erreur, on continue avec 0
        }

        $tauxPresence = $totalPresences > 0 ? round(($presencesMarquees / $totalPresences) * 100, 1) : 0;

        return view('coordinateur.dashboard', compact(
            'user',
            'totalMatieres',
            'totalSeances',
            'totalClasses',
            'totalEtudiants',
            'seancesAujourdhui',
            'prochainesSeances',
            'seancesRecentes',
            'matieresRecentes',
            'tauxPresence'
        ));
    }
}
