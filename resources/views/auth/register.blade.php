<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Aventureiro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a8a5e6;
            --accent-color: #ff7675;
            --dark-bg: #2d2d3d;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1a1a2c 100%);
            min-height: 100vh;
            color: white;
        }

        .rpg-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background: linear-gradient(45deg, var(--primary-color), #857ddb);
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            text-align: center;
            border-bottom: none;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.25);
            color: white;
        }

        .btn-rpg {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-rpg:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }

        .btn-rpg::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, 
                transparent, 
                rgba(255, 255, 255, 0.1), 
                transparent);
            transform: rotate(45deg);
            transition: all 0.5s;
        }

        .btn-rpg:hover::after {
            left: 50%;
        }

        .link-rpg {
            color: var(--secondary-color);
            text-decoration: none;
            position: relative;
        }

        .link-rpg:hover {
            color: white;
        }

        .link-rpg::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }

        .link-rpg:hover::after {
            width: 100%;
        }

        .invalid-feedback {
            background: rgba(255, 118, 117, 0.1);
            padding: 8px 12px;
            border-radius: 6px;
            margin-top: 5px;
        }

        .brand-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="rpg-card shadow-lg">
                    <div class="card-header">
                        <i class="bi bi-shield-shaded brand-icon"></i>
                        <h3 class="mb-0">Criar Nova Conta</h3>
                        <small>Comece sua jornada épica</small>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Nome -->
                            <div class="mb-4">
                                <label for="name" class="form-label">Nome do Aventureiro</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required
                                       placeholder="Ex: Aragorn II">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Pergaminho Mágico (E-mail)</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required
                                       placeholder="exemplo@reino.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Senha -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Senha Secreta</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required
                                       placeholder="••••••••">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmar Senha -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required
                                       placeholder="••••••••">
                            </div>

                            <button type="submit" class="btn btn-rpg w-100 py-3">
                                <i class="bi bi-dice-5 me-2"></i>Registrar
                            </button>
                        </form>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('login') }}" class="link-rpg">
                                Já possui uma conta? Faça login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>