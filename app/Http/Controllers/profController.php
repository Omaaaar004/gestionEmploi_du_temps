<?php

namespace App\Http\Controllers;

use App\Models\Prof;
use App\Models\Departement;
use Illuminate\Http\Request;

class profController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profs = prof::with('departement')->get();
        return view('profs.index', compact('profs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Departement::all();
        return view('profs.create',compact('departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'specialite' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:profs,email',
        'departement_id' => 'required|exists:departements,id',
    ]);
        Prof::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'specialite'=>$request->specialite,
            'email' => $request->email,
            'departement_id' => $request->departement_id 
        ]);
        return redirect()->route('profs.index')->with('success','Professeur ajouté(e) !');
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
        $prof = Prof::findOrFail($id);
        $departements = Departement::all();
        return view('profs.edit', compact('prof','departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'specialite' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:profs,email',
        'departement_id' => 'required|exists:departements,id',
    ]);
        $prof = Prof::finOrFail($id);
        $prof->nom = $request->nom;
        $prof->prenom = $request->prenom;
        $prof->specialite = $request->specialite;
        $prof->email = $request->email;
        $prof->departement_id = $request->departement_id;
        $prof->save();
        return redirect()->route('profs.index')->with('success', 'Professeur modifié(e) !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prof = Prof::findOrFail($id)->delete();
        return redirect()->route('profs.index')->with('success', 'Professeur supprimé(e) !');
    }
}
