<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion d'Emploi du temps - UMP</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body{
            background: #f0f2f5;
            min-height: 100vh;
        }

        /* sidebar */
        .sidebar {
            width: 250px;
            background: #1a237e;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .sidebar .logo{
            text-align: center;
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
        }
        .sidebar .logo a {
            text-decoration: none;
            color: white;
        }
        .sidebar .logo h2{
            font-size: 22px;
            font-weight: 700;
        }
        .sidebar .logo p{
            font-size: 11px;
            color: rgba(255,255,255,0.6);
            margin-top: 4px;
        }
        .sidebar a{
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 14px;
        }
        .sidebar a:hover{
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar a.active{
            background: rgba(255,255,255,0.15);
            color: white;
            border-left: 4px solid #fff;   
        }
        .sidebar .menu-title{
            padding: 20px 25px 10px;
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        /* main content area */
        .main{
            margin-left: 250px; /* Espace pour la sidebar */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* navbar */
        .navbar{
            background: white;
            height: 70px;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: fixed;
            top: 0;
            right: 0;
            left: 250px; /* Commence après la sidebar */
            z-index: 900;
            transition: left 0.3s ease;
        }
        .navbar h1{
            font-size: 20px;
            color: #1a237e;
            font-weight: 600;
        }
        .navbar .user{
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        .navbar .user .avatar{
            background: #1a237e;
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* content padding top for fixed navbar */
        .content{
            padding: 30px;
            margin-top: 70px; /* Hauteur de la navbar */
            flex: 1;
        }

        /* Components */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            overflow-x: auto; /* Handle large tables automatically */
        }
        @media (max-width: 768px) {
            .card { padding: 15px; }
        }
        .btn{
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-primary{ background: #1a237e; color: white; }
        .btn-primary:hover{ background: #283593; transform: translateY(-1px); }
        .btn-secondary{ background: #e0e0e0; color: #333; }
        
        /* Tables (Global) */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
            border-radius: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
            white-space: nowrap; /* Prevent text wrapping in headers */
        }
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        table th {
            background: #f8f9fa;
            color: #333;
            font-weight: 600;
        }
        table tbody tr:hover {
            background: #f8fafc;
        }

        /* Forms (Global) */
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #1a237e;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
        }
        .hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: #1a237e;
            border-radius: 2px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 950;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .navbar { left: 0; }
            .hamburger { display: flex; }
            .sidebar-overlay.active { display: block; }
        }
    </style>
    @yield('style')
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <a href="{{ url('/') }}">
                <h2>UMPO</h2>
                <p>Université Mohammed Premier Oujda</p>
            </a>
        </div>
        <div class="menu-title">Principal</div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Tableau de bord</a>
        <a href="{{ route('seances.index') }}" class="{{ request()->routeIs('seances.*') ? 'active' : '' }}">📅 Emploi du temps</a>
        
        <div class="menu-title">Administration</div>
        <a href="{{ route('composantes.index') }}">🏫 Composantes</a>
        <a href="{{ route('departements.index') }}">🏢 Départements</a>
        <a href="{{ route('filieres.index') }}">📚 Filières</a>
        <a href="{{ route('semestres.index') }}">🎓 Semestres</a>
        <a href="{{ route('modules.index') }}">📖 Modules</a>
        <a href="{{ route('profs.index') }}">👨‍🏫 Professeurs</a>
        
        <div class="menu-title">Locaux</div>
        <a href="{{ route('zones.index') }}">🗺️ Zones</a>
        <a href="{{ route('locals.index') }}">🚪 Locaux</a>

        <div class="menu-title">Compte</div>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #ff5252;">
            🚪 Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="main">
        <div class="navbar">
            <div style="display:flex; align-items:center; gap:15px;">
                <button class="hamburger" id="hamburgerBtn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <h1>@yield('title', 'Tableau de bord')</h1>
            </div>
            <div class="user">
                @auth
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <span>{{ Auth::user()->name }}</span>
                @else
                    <div class="avatar">?</div>
                    <span>Invité</span>
                @endauth
            </div>
        </div>
        
        <div class="content">
            @if(session('success'))
                <div style="background:#e8f5e9; color:#2e7d32; padding:15px; border-radius:8px; margin-bottom:20px; border-left:5px solid #4caf50;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        hamburgerBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Close sidebar on link click (mobile)
        sidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                }
            });
        });
    </script>
    @yield('script')
</body>
</html>