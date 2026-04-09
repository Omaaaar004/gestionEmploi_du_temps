<?php

namespace App\Http\Controllers;
use App\Models\Composante;
use Illuminate\Http\Request;

class composanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $composantes = Composante::all();
        return view('composantes.index', compact('composantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('composantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Composante::create([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
        ]);
        return redirect()->route('composantesr.index')->with('success','Composante Ajoutée !');
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
        $composante = Composante::findOrFail($id);
        return view('composantes.edit',compact('composante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $composante = Composante::findOrFail($id);
        $composante->nom = $request->nom;
        $composante->adresse = $request->adresse;
        $composante->save();
        return redirect()->route('composantes.index')->with('success','Composante modifiée !'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Composite::findOrFail($id)->delete();
        return redirect()->route('composante.index')->with('success','Composante supprimée !');
    }
}
