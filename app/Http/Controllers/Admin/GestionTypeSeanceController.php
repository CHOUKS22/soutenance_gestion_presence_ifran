<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type_seance;
use Illuminate\Http\Request;

class GestionTypeSeanceController extends Controller
{
    public function index()
    {
        $types_seances = Type_seance::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.types-seances.types-seances', compact('types_seances'));
    }

    public function show(Type_seance $type_seance)
    {
        return view('admin.types-seances.type-seance-show', compact('type_seance'));
    }

    public function create()
    {
        return view('admin.types-seances.type-seance-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:types_seances',
            'description' => 'required|string|max:1000',
        ]);

        Type_seance::create($validated);

        return redirect()->route('gestion-types-seances.index')->with('success', 'Type de séance créé avec succès.');
    }

    public function edit(Type_seance $type_seance)
    {
        return view('admin.types-seances.type-seance-edit', compact('type_seance'));
    }

    public function update(Request $request, Type_seance $type_seance)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:types_seances,nom,' . $type_seance->id,
            'description' => 'required|string|max:1000',
        ]);

        $type_seance->update($validated);

        return redirect()->route('gestion-types-seances.index')->with('success', 'Type de séance modifié avec succès.');
    }

    public function destroy(Type_seance $type_seance)
    {
        $type_seance->delete();
        return redirect()->route('gestion-types-seances.index')->with('success', 'Type de séance supprimé avec succès.');
    }
}
