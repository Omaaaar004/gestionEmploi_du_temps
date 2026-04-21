<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use App\Models\Filiere;
use Illuminate\Http\Request;

// app/Http/Controllers/SemestreController.php


class SemestreController extends Controller
{
    // Liste tous les semestres
    public function index()
    {
        $semestres = Semestre::with('filiere')->get();
        return view('semestres.index', compact('semestres'));
    }

    // Formulaire de création
    public function create()
    {
        $filieres = Filiere::all();
        return view('semestres.create', compact('filieres'));
    }

    // Enregistrer un nouveau semestre
    public function store(Request $request)
    {
        
        $request->validate([
            'nom'=>'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id'

        ]);
        Semestre::create([
            'nom' => $request->nom,
            'filiere_id' => $request->filiere_id
        ]);

        return redirect()->route('semestres.index')->with('success', 'Semestre créé avec succès !');
    }

    // Formulaire de modification
    public function edit($id)
    {
        $semestre = Semestre::findOrFail($id);
        $filieres = Filiere::all();
        return view('semestres.edit', compact('semestre','filieres'));
    }

    // Mettre à jour un semestre
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom'  => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id'
        ]);

        $semestre = Semestre::findOrFail($id);
        $semestre->nom = $request->nom;
        $semestre->filiere_id = $request->filiere_id;
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
