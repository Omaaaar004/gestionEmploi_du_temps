<?php

namespace App\Http\Controllers;

use App\Models\Locals;
use App\Models\Zone;
use Illuminate\Http\Request;

class localController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locals = Locals::with('zone')->get();
        return view('locals.index', compact('locals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::all();
        return view('locals.create', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
        'nom_local' => 'required|string|max:255',
        'capacite' => 'nullable|integer',
        'zone_id' => 'required|exists:zones,id',
    ]);
        Locals::create([
            'nom_local' => $request->nom_local,
            'capacite' => $request->capacite,
            'zone_id' => $request->zone_id
        ]);

        return redirect()->route('locals.index')->with('success', 'Local ajouté');
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
        $local = Locals::findOrFail($id);
        $zones = Zone::all();
        return view('locals.edit', compact('local', 'zones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nom_local' => 'required|string|max:255',
        'capacite' => 'nullable|integer',
        'zone_id' => 'required|exists:zones,id',
    ]);
        $local = Locals::findOrFail($id);
        $local->nom_local = $request->nom_local;
        $local->capacite = $request->capacite;
        $local->zone_id = $request->zone_id;
        $local->save();
        return redirect()->route('locals.index')->with('success', 'Local modifié !') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Locals::findOrFail($id)->delete();
        return redirect()->route('locals.index')->with('success', 'Local supprimé !');
    }
}
