<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesrion Emploi du temps - UMP</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:'Segoe UI' sans-serif;
        }

        body{
            display: flex;
            min-height: 100vh;
            background: #f0f2f5;
        }
        /* sidebar */
        .sidebar {
            width: 250px;
            background: #1a237e;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar .logo{
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar .logo h2{
            font-size: 18px;
            color: white;
        }
        .sidebar .logo p{
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            margin-top: 6px;
        }
        .sidebar a{
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
        }
        .sidebar a:hover{
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 35px;
        }
        .sidebar a.active{
            background: rgba(255,255,255,0.2);
            color: white;
            border-left: 4px solid #fff;   
        }
        .sidebar .menu-title{
            padding: 10px 25px;
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }
        /* main content*/
        .main{
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        /*navbar*/
        .navbar{
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content:space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar h1{
            font-size: 20px;
            color: #1a237e;
        }
        .navbar .user{
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #555;
        }
        .navbar .user span{
            background: #1a237e;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            align-items: center;
            display: flex;
            justify-content: center;
            font-weight: bold;
        }
        /* content */
        .content{
            padding: 30px;
            flex: 1;
        }
        /* cards */
        .card{
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .card-header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .card-header h2{
            font-size: 18px;
            color: #1a237e;
        }
        /* alerts*/
        .alert{
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #43a047;
        }
        .alert-danger{
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #e53935;
        }
    </style>
</head>
<body>
    <!-- sideBar-->
    <div class="sidebar">
        <div class="logo">
            <h2>UMPO</h2>
            <p>Faculté Mohammed Premier Oujda</p>
        </div>
        <div class="menu-title">
            Principal
        </div>
        <a href="{{ route('seances.index') }}">📅 Emploi du temps</a>
        <div class="menu-title">Administration</div>
        <a href="{{ route('composantes.index') }}">🏫 Composantes</a>
        <a href="{{ route('departements.index') }}">🏢 Départements</a>
        <a href="{{ route('filieres.index') }}">📚 Filières</a>
        <a href="{{ route('etapes.index') }}">📋 Étapes</a>
        <a href="{{ route('modules.index') }}">📖 Modules</a>
        <a href="{{ route('profs.index') }}">👨‍🏫 Professeurs</a>
        <div class="menu-title">Locaux</div>
        <a href="{{ route('zones.index') }}">🗺️ Zones</a>
        <a href="{{ route('locals.index') }}">🚪 Locaux</a>
    </div>

    <!--main-->
    <div class="main">
        <div class="navbar">
            <h1>@yield('title', 'Tableau de bord')</h1>
            <div class="user">
                <span>A</span>
                Admin
            </div>
        </div>
        <div class="content">
            @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>