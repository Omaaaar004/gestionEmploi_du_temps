<?php

namespace App\Http\Controllers;

use App\Models\Etape;
use App\Models\Filiere;
use Illuminate\Http\Request;

class etapeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etapes = Etape::with('filiere')->get();
        return view('etapes.index', compact('etapes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filieres = Filiere::all();
        return view('etapes.create', compact('filieres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'niveau' =>'required|string|max:150',
        'filiere_id' => 'required|exists:filieres,id',
    ]);
        Etape::create([
            'nom' => $request->nom,
            'niveau' => $request->niveau,
            'filiere_id' => $request->filiere_id
        ]);
        return redirect()->route('etapes.index')->with('success', 'Étape ajoutée !');
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
        $etape = Etape::findOrFail($id);
        $filieres = Filiere::all();

        return view('etapes.edit', compact('etape', 'filieres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'niveau' =>'required|string|max:150',
        'filiere_id' => 'required|exists:filieres,id',
    ]);
        $etape = Etape::findOrFail($id);
        $etape->nom = $request->nom;
        $etape->niveau = $request->niveau;
        $etape->filiere_id = $request->filiere_id;
        $etape->save();
        return redirect()->route('etapes.index')->with('success', 'Étape modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Etape::findOrFail($id)->delete();
        return redirect()->route('etapes.index')->with('success', 'Étape supprimée');
    }
}
