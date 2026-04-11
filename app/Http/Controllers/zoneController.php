<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class zoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::all();
        return view('zones.index',compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('zones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
        'nom_zone' => 'required|string|max:255',
        'code_zone' => 'nullable|string|max:100',
        'description' => 'nullable|string',
    ]);
        Zone::create([
            'nom_zone' => $request->nom_zone,
            'code_zone' => $request->code_zone,
            'description' => $request->description
        ]);
        return redirect()->route('zones.index')->with('success','Zone ajoutée');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $zone = Zone::FindOrFail($id);
        return view('zones.edit', compact('zone')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nom_zone' => 'required|string|max:255',
        'code_zone' => 'nullable|string|max:100',
        'description' => 'nullable|string',
    ]);
        $zone = Zone::findOrfail($id);
        $zone->nom_zone = $request->nom_zone;
        $zone->code_zone = $request->code_zone;
        $zone->description = $request->description;
        $zone->save();
        return redirect()->route('zones.index')->with('succcess','Zone modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Zone::findOrFail($id)->delete();
        return redirect()->route('zones.index')->with('success','Zone supprimée !');
    }
}
