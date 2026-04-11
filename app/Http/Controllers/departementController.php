<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Composante;
use Illuminate\Http\Request;

class departementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departements = Departement::with('composante')->get();
        return view('departement.index', compact('departements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $composantes = Composante::all();
        return view('departements.create',compact('composantes')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'composante_id' => 'required|exists:composantes,id',
    ]);
        Departement::create([
            'nom' => $request->nom,
            'composante_id' => $request->composante_id
        ]);
        return redirect()->route('departements.index')->with('success','Departement ajouté !');
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
        $departement = Departement::findOrFail($id);
        $composantes = Composante::all();
        return view('departements.edit', compact('departement','composantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'composante_id' => 'required|exists:composantes,id',
    ]);
        $departement = Departement::findOrFail($id);
        $departement->nom = $request->nom;
        $departement->composante_id = $request->composante_id;
        return redirect()->route('composantes.index')->with('success','Departement modifié !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Departement::findOrFail($id)->delete();
        return redirect()->route('departements.index')->with('success', 'Departement Supprimé');
    }
}
