<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Illuminate\Http\Request;

class GestionClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.classes.classes', compact('classes'));
    }

    public function show(Classe $classe)
    {
        return view('admin.classes.classe-show', compact('classe'));
    }

    public function create()
    {
        return view('admin.classes.classe-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:classes',
        ]);

        Classe::create($validated);

        return redirect()->route('gestion-classes.index')->with('success', 'Classe créée avec succès.');
    }

    public function edit(Classe $classe)
    {
        return view('admin.classes.classe-edit', compact('classe'));
    }

    public function update(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:classes,nom,' . $classe->id,
        ]);

        $classe->update($validated);

        return redirect()->route('gestion-classes.index')->with('success', 'Classe modifiée avec succès.');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->route('gestion-classes.index')->with('success', 'Classe supprimée avec succès.');
    }
}
