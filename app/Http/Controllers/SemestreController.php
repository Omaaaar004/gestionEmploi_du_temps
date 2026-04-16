<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use App\Models\Etape;
use Illuminate\Http\Request;

// app/Http/Controllers/SemestreController.php


class SemestreController extends Controller
{
    // Liste tous les semestres
    public function index()
    {
        $semestres = Semestre::with('etape')->get();
        return view('semestres.index', compact('semestres'));
    }

    // Formulaire de création
    public function create()
    {
        $etapes = Etape::all();
        return view('semestres.create', compact('etapes'));
    }

    // Enregistrer un nouveau semestre
    public function store(Request $request)
    {
        $request->validate([
            'nom'      => 'required|string|max:255',
            'etape_id' => 'required|exists:etapes,id',
        ]);

        Semestre::create($request->only('nom', 'etape_id'));

        return redirect()->route('semestres.index')
                         ->with('success', 'Semestre créé avec succès !');
    }

    // Formulaire de modification
    public function edit(Semestre $semestre)
    {
        $etapes = Etape::all();
        return view('semestres.edit', compact('semestre', 'etapes'));
    }

    // Mettre à jour un semestre
    public function update(Request $request, Semestre $semestre)
    {
        $request->validate([
            'nom'      => 'required|string|max:255',
            'etape_id' => 'required|exists:etapes,id',
        ]);

        $semestre->update($request->only('nom', 'etape_id'));

        return redirect()->route('semestres.index')
                         ->with('success', 'Semestre mis à jour avec succès !');
    }

    // Supprimer un semestre
    public function destroy(Semestre $semestre)
    {
        $semestre->delete();

        return redirect()->route('semestres.index')
                         ->with('success', 'Semestre supprimé avec succès !');
    }
}
