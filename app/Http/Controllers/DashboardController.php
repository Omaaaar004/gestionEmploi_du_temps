<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filiere;
use App\Models\Prof;
use App\Models\Seance;
use App\Models\Module;
use App\Models\Locals;
use App\Models\Semestre;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'filieres' => Filiere::count(),
            'profs' => Prof::count(),
            'seances' => Seance::count(),
            'modules' => Module::count(),
            'locals' => Locals::count(),
            'semestres' => Semestre::count(),
        ];

        // Dernières séances ajoutées
        $recent_seances = Seance::with(['module', 'prof', 'filiere', 'semestre', 'local'])
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('dashboard', compact('stats', 'recent_seances'));
    }
}
