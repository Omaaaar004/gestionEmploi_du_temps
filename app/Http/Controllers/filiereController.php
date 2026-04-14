<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Departement;
use Illuminate\Http\Request;

class filiereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filieres = Filiere::with('departement')->get();
        return view('filieres.index',compact('filieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $departements = Departement::all();
       return view('filieres.create',compact('departements'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'type_formation' => 'nullable|string|max:255',
        'departement_id' => 'required|exists:departements,id',
        ]);
         Filiere::create([
            'nom' => $request->nom,
            'type_formation' => $request->type_formation,
            'departement_id' => $request->departement_id
        ]);

        return redirect()->route('filieres.index')->with('success', 'Filière ajoutée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $filiere = Filiere::findOrFail($id);
        $departements = Departement::all();
        return view('filieres.edit', compact('filiere','departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $request->validate([
        'nom' => 'required|string|max:255',
        'type_formation' => 'nullable|string|max:255',
        'departement_id' => 'required|exists:departements,id',
    ]);
        $filiere = Filiere::findOrFail($id);
        $filiere->nom = $request->nom;
        $filiere->type_formation = $request->type_formation;
        $filiere->departement_id = $request->departement_id;
        $filiere->save();
        
        return redirect()->route('filieres.index')->with('success', 'Filière modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Filiere::findOrFail($id)->delete();
        return redirect()->route('filieres.index')->with('success', 'Filière supprimée');
    }
}
