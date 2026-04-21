<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion UMP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
        }
        .logo-area {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-area i {
            font-size: 50px;
            color: #1a237e;
        }
        .logo-area h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1a237e;
            margin-top: 10px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25 margin: rgba(26, 35, 126, 0.25);
            border-color: #1a237e;
        }
        .btn-login {
            background: #1a237e;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #0d1440;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-area">
            <i class="fas fa-university"></i>
            <h1>Gestion UMP</h1>
            <p class="text-muted">Accès Administration</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control border-start-0" placeholder="exemple@ump.ac.ma" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                Se connecter <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="small text-muted">© 2026 Université Mohammed Premier</p>
        </div>
    </div>

</body>
</html>
