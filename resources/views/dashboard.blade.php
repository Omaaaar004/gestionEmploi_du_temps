@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('style')
<style>
    /* Scoped Variables */
    #premium-dashboard {
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #047857 100%);
        --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);
        --danger-gradient: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        --info-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        --purple-gradient: linear-gradient(135deg, #8b5cf6 0%, #5b21b6 100%);
    }

    /* Animations */
    @keyframes dashSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes dashFloat {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }

    /* Dashboard Wrapper to prevent CSS leaking */
    #premium-dashboard {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Welcome Banner */
    #premium-dashboard .welcome-banner {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 35px 40px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(49, 46, 129, 0.2);
        animation: dashSlideUp 0.6s ease-out;
    }

    #premium-dashboard .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        filter: blur(40px);
    }
    
    #premium-dashboard .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -50%;
        right: 10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        filter: blur(20px);
    }

    #premium-dashboard .welcome-text h2 {
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 10px 0;
        letter-spacing: -0.5px;
        color: white;
    }

    #premium-dashboard .welcome-text p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
        font-weight: 400;
    }

    #premium-dashboard .welcome-date {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 12px 25px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Stats Grid */
    #premium-dashboard .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 25px;
        margin-bottom: 35px;
    }

    #premium-dashboard .premium-stat-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
        animation: dashSlideUp 0.6s ease-out backwards;
    }
    
    #premium-dashboard .stats-grid .premium-stat-card:nth-child(1) { animation-delay: 0.1s; }
    #premium-dashboard .stats-grid .premium-stat-card:nth-child(2) { animation-delay: 0.2s; }
    #premium-dashboard .stats-grid .premium-stat-card:nth-child(3) { animation-delay: 0.3s; }
    #premium-dashboard .stats-grid .premium-stat-card:nth-child(4) { animation-delay: 0.4s; }

    #premium-dashboard .premium-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    #premium-dashboard .stat-icon-wrapper {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        transition: transform 0.3s ease;
    }

    #premium-dashboard .premium-stat-card:hover .stat-icon-wrapper {
        animation: dashFloat 2s infinite ease-in-out;
    }

    #premium-dashboard .card-seances .stat-icon-wrapper { background: var(--info-gradient); box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3); }
    #premium-dashboard .card-profs .stat-icon-wrapper { background: var(--purple-gradient); box-shadow: 0 8px 16px rgba(139, 92, 246, 0.3); }
    #premium-dashboard .card-filieres .stat-icon-wrapper { background: var(--success-gradient); box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3); }
    #premium-dashboard .card-locals .stat-icon-wrapper { background: var(--warning-gradient); box-shadow: 0 8px 16px rgba(245, 158, 11, 0.3); }

    #premium-dashboard .stat-details h4 {
        margin: 0;
        font-size: 14px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    #premium-dashboard .stat-details h3 {
        margin: 5px 0 0;
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    /* Content Layout */
    #premium-dashboard .dashboard-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        animation: dashSlideUp 0.6s ease-out backwards;
        animation-delay: 0.5s;
    }

    @media (max-width: 1200px) {
        #premium-dashboard .dashboard-layout { grid-template-columns: 1fr; }
    }

    #premium-dashboard .premium-panel {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0,0,0,0.02);
    }

    #premium-dashboard .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    #premium-dashboard .panel-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #premium-dashboard .panel-header h3::before {
        content: '';
        display: block;
        width: 12px;
        height: 12px;
        background: #4f46e5;
        border-radius: 3px;
    }

    #premium-dashboard .btn-new {
        background: #f1f5f9;
        color: #4f46e5;
        border-radius: 10px;
        font-weight: 700;
        padding: 10px 18px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
    }

    #premium-dashboard .btn-new:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }

    /* Premium Table */
    #premium-dashboard .premium-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
        margin-top: -10px;
    }

    #premium-dashboard .premium-table th {
        text-align: left;
        padding: 0 15px 10px;
        color: #64748b;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    #premium-dashboard .premium-table tbody tr {
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    #premium-dashboard .premium-table tbody tr:hover {
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transform: scale(1.01);
    }

    #premium-dashboard .premium-table td {
        padding: 16px 15px;
        font-size: 14px;
        font-weight: 500;
        color: #334155;
    }

    #premium-dashboard .premium-table td:first-child { border-radius: 12px 0 0 12px; }
    #premium-dashboard .premium-table td:last-child { border-radius: 0 12px 12px 0; }

    #premium-dashboard .badge-jour {
        background: #e0e7ff;
        color: #4f46e5;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        display: inline-block;
    }

    #premium-dashboard .prof-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #premium-dashboard .prof-avatar {
        width: 32px;
        height: 32px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
    }

    /* Quick Actions */
    #premium-dashboard .quick-actions-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    #premium-dashboard .action-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        background: #f8fafc;
        border-radius: 16px;
        color: #0f172a;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    #premium-dashboard .action-btn:hover {
        background: white;
        border-color: #e2e8f0;
        box-shadow: 0 10px 20px rgba(0,0,0,0.04);
        transform: translateY(-2px);
    }

    #premium-dashboard .action-btn .icon-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    #premium-dashboard .action-btn .icon-bg {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    #premium-dashboard .action-btn .arrow {
        color: #94a3b8;
        transition: transform 0.3s;
    }

    #premium-dashboard .action-btn:hover .arrow {
        transform: translateX(5px);
        color: #4f46e5;
    }
</style>
@endsection

@section('content')

<div id="premium-dashboard">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-text">
            <h2>Bienvenue, {{ Auth::user()->name ?? 'Administrateur' }}! 👋</h2>
            <p>Gérez et suivez l'emploi du temps de votre université en toute simplicité.</p>
        </div>
        <div class="welcome-date">
            <span style="font-size: 20px;">🗓️</span>
            <span style="font-weight: 600; font-size: 15px;">{{ \Carbon\Carbon::now()->locale('fr_FR')->translatedFormat('l j F Y') }}</span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="premium-stat-card card-seances">
            <div class="stat-icon-wrapper">📅</div>
            <div class="stat-details">
                <h4>Séances Actives</h4>
                <h3>{{ $stats['seances'] }}</h3>
            </div>
        </div>
        
        <div class="premium-stat-card card-profs">
            <div class="stat-icon-wrapper">👨‍🏫</div>
            <div class="stat-details">
                <h4>Professeurs</h4>
                <h3>{{ $stats['profs'] }}</h3>
            </div>
        </div>
        
        <div class="premium-stat-card card-filieres">
            <div class="stat-icon-wrapper">📚</div>
            <div class="stat-details">
                <h4>Filières</h4>
                <h3>{{ $stats['filieres'] }}</h3>
            </div>
        </div>
        
        <div class="premium-stat-card card-locals">
            <div class="stat-icon-wrapper">🚪</div>
            <div class="stat-details">
                <h4>Salles & Locaux</h4>
                <h3>{{ $stats['locals'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Dashboard Layout -->
    <div class="dashboard-layout">
        <!-- Recent Seances -->
        <div class="premium-panel">
            <div class="panel-header">
                <h3>Dernières Séances Ajoutées</h3>
                <a href="{{ route('seances.create') }}" class="btn-new">+ Nouvelle Séance</a>
            </div>
            
            @if($recent_seances->count() > 0)
            <div style="overflow-x: auto;">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Jour & Heure</th>
                            <th>Module</th>
                            <th>Professeur</th>
                            <th>Filière</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_seances as $seance)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span class="badge-jour">{{ $seance->jour }}</span>
                                    <span style="color: #64748b; font-size: 13px;">{{ substr($seance->heure_deb,0,5) }} - {{ substr($seance->heure_fin,0,5) }}</span>
                                </div>
                            </td>
                            <td style="color: #0f172a; font-weight: 700;">{{ $seance->module->nom ?? 'N/A' }}</td>
                            <td>
                                <div class="prof-name">
                                    <div class="prof-avatar">
                                        {{ substr($seance->prof->nom ?? 'P', 0, 1) }}
                                    </div>
                                    <span>{{ $seance->prof->nom ?? '' }} {{ $seance->prof->prenom ?? '' }}</span>
                                </div>
                            </td>
                            <td>
                                <span style="background: #f1f5f9; padding: 5px 10px; border-radius: 6px; font-size: 12px; color: #475569;">
                                    {{ $seance->filiere->nom ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div style="text-align: center; padding: 50px 20px;">
                <div style="font-size: 50px; margin-bottom: 15px; opacity: 0.5;">📭</div>
                <h4 style="color: #64748b; font-size: 18px; margin: 0;">Aucune séance trouvée</h4>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="premium-panel">
            <div class="panel-header">
                <h3>Actions Rapides</h3>
            </div>
            
            <div class="quick-actions-grid">
                <a href="{{ route('seances.index') }}" class="action-btn">
                    <div class="icon-left">
                        <div class="icon-bg" style="color: #4f46e5;">🗓️</div>
                        <span>Gérer l'emploi du temps</span>
                    </div>
                    <span class="arrow">➔</span>
                </a>
                
                <a href="{{ route('profs.index') }}" class="action-btn">
                    <div class="icon-left">
                        <div class="icon-bg" style="color: #8b5cf6;">👥</div>
                        <span>Liste des professeurs</span>
                    </div>
                    <span class="arrow">➔</span>
                </a>
                
                <a href="{{ route('filieres.index') }}" class="action-btn">
                    <div class="icon-left">
                        <div class="icon-bg" style="color: #10b981;">🎓</div>
                        <span>Gérer les filières</span>
                    </div>
                    <span class="arrow">➔</span>
                </a>
                
                <a href="{{ route('locals.index') }}" class="action-btn">
                    <div class="icon-left">
                        <div class="icon-bg" style="color: #f59e0b;">🏢</div>
                        <span>Salles et amphithéâtres</span>
                    </div>
                    <span class="arrow">➔</span>
                </a>
            </div>
            
            <!-- System Status Summary -->
            <div style="margin-top: 30px; padding: 20px; background: #f8fafc; border-radius: 16px; border: 1px dashed #cbd5e1;">
                <h4 style="margin: 0 0 15px 0; font-size: 14px; color: #64748b; text-transform: uppercase;">Aperçu du système</h4>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #475569; font-weight: 500; font-size: 14px;">Modules enregistrés</span>
                    <span style="font-weight: 700; color: #0f172a;">{{ $stats['modules'] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #475569; font-weight: 500; font-size: 14px;">Semestres actifs</span>
                    <span style="font-weight: 700; color: #0f172a;">{{ $stats['semestres'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
