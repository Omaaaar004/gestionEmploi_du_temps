<?php
use Illuminate\Support\Facades\Route;

Route::get('/del', function(\Illuminate\Http\Request $request) {
    $user = \App\Models\User::where('email', $request->email)->first();
    if ($user) { $user->delete(); return "Supprimé"; }
    return "Non trouvé";
});



use Illuminate\Support\Facades\Routes;
use App\Http\Controllers\ComposanteController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\EtapeController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\AuthController;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route temporaire pour créer l'admin (À SUPPRIMER APRÈS UTILISATION)
Route::get('/create-admin', function() {
    try {
        User::updateOrCreate(
            ['email' => 'admin@ump.ma'],
            [
                'name' => 'Omar Admin',
                'password' => Hash::make('admin123'),
            ]
        );
        return "✅ Compte Admin créé avec succès ! <br> Email: admin@ump.ma | Pass: admin123 <br> <a href='/login'>Aller à la connexion</a>";
    } catch (\Exception $e) {
        return "❌ Erreur lors de la création : " . $e->getMessage();
    }
});

Route::get('/test-admin', function() {
    User::updateOrCreate(['email' => 'admin@ump.ma'], ['name' => 'Omar', 'password' => Hash::make('admin123')]);
    return "Test OK - Admin créé";
});

// Route pour ajouter n'importe quel utilisateur via l'URL
// Exemple : /add-user?name=Ahmed&email=ahmed@ump.ma&password=123
Route::get('/add-user', function(\Illuminate\Http\Request $request) {
    if (!$request->email || !$request->password) {
        return "Veuillez préciser ?name=...&email=...&password=... dans l'adresse.";
    }
    User::updateOrCreate(
        ['email' => $request->email],
        [
            'name' => $request->name ?? 'Utilisateur',
            'password' => Hash::make($request->password),
        ]
    );
    return "✅ Utilisateur créé : " . $request->email;
});

// Route pour supprimer un utilisateur via l'URL
// Exemple : /delete-user?email=ahmed@ump.ma
Route::get('/delete-user', function(\Illuminate\Http\Request $request) {
    if (!$request->email) {
        return "Veuillez préciser ?email=... dans l'adresse.";
    }
    $user = User::where('email', $request->email)->first();
    if ($user) {
        $user->delete();
        return "🗑️ Utilisateur supprimé : " . $request->email;
    }
    return "❌ Utilisateur non trouvé.";
});



// Route pour le Dashboard
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Routes protégées
Route::middleware(['auth'])->group(function () {
    Route::get('/seances/events', [SeanceController::class, 'events'])->name('seances.events');
    Route::get('/seances/modules/{filiereId}/{semestreId}', [SeanceController::class, 'getModulesByFiliereAndSemestre']);
    Route::get('/seances/semestres/{filiereId}', [SeanceController::class, 'getSemestresByFiliere'])->name('seances.semestres.by.filiere');

    Route::resource('composantes', ComposanteController::class);
    Route::resource('zones', ZoneController::class);
    Route::resource('locals', LocalController::class);
    Route::resource('departements', DepartementController::class);
    Route::resource('filieres', FiliereController::class);
    Route::resource('etapes', EtapeController::class);
    Route::resource('profs', ProfController::class);
    Route::resource('seances', SeanceController::class);
    Route::resource('modules', ModuleController::class);
    Route::resource('semestres', SemestreController::class);
});