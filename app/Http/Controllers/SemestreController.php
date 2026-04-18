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
        $semestres = Semestre::all();
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
            'nom'=>'required|string|max:255',

        ]);
        Semestre::create([
            'nom' => $request->nom
        ]);

        return redirect()->route('semestres.index')->with('success', 'Semestre créé avec succès !');
    }

    // Formulaire de modification
    public function edit($id)
    {
        $semestre = Semestre::findOrFail($id);
        return view('semestres.edit', compact('semestre'));
    }

    // Mettre à jour un semestre
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom'      => 'required|string|max:255',
        ]);

        $semestre->update($request->only('nom'));
        $semestre->save();
        return redirect()->route('semestres.index')->with('success', 'Semestre mis à jour avec succès !');
    }

    // Supprimer un semestre
    public function destroy($id)
    {
        Semestre::findOrfail($id)->delete();
        return redirect()->route('semestres.index')->with('success', 'Semestre supprimer !');
    }
}
