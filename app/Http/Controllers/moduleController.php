<?php

namespace App\Http\Controllers;
use App\Models\Module;
use App\Models\Etape;
use Illuminate\Http\Request;

class moduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::with('etape')->get();
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etapes = Etape::all();
        return view('module.create', compact('etapes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'etape_id' => 'required|exists:etapes,id',
    ]);
        Module::create([
            'nom' => $request->nom,
            'etape_id' => $request->etape_id
        ]);
        return redirect()->route('modules.index')->with('success', 'Module ajouté !');
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
        $module = Module::findOrFail($id);
        $etapes = Etape::all();
        return view('modules.edit', compact('module','etapes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'etape_id' => 'required|exists:etapes,id',
    ]);
        $module = Module::findOrFail($id);
        $module->nom = $request->nom;
        $module->etape_id = $request->etape_id;
        $module->save();
        return redirect()-route('modules.index')->with('success', 'Module modifié !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $module = Module::findOrFail($id)->delete();
        return redirect()->route('modules.index')->with('success', 'Module supprimé !');
    }
}
