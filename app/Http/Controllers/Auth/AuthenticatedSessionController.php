<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Logique de redirection selon le rôle
        $user = Auth::user();

        if ($user && $user->role) {
            switch ($user->role->nom) {
                case 'Administrateur':
                    return redirect()->route('admin.dashboard');
                case 'Professeur':
                    return redirect()->route('professeur.dashboard');
                case 'Coordinateur':
                    return redirect()->route('coordinateur.dashboard');
                case 'Parent':
                    return redirect()->route('parent.dashboard');
                case 'Etudiant':
                    return redirect()->route('etudiant.dashboard');
                default:
                    // Si le rôle n'est pas reconnu, déconnecter et rediriger vers login
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Rôle non autorisé. Veuillez vous reconnecter.');
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
