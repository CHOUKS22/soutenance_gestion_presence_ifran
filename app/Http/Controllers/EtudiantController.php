<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EtudiantController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('etudiant.dashboard', compact('user'));
    }

}
