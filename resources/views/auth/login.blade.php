<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acesso ao Reino Épico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --metal-dark: #3a3a3a;
            --metal-mid: #6b6b6b;
            --metal-light: #9e9e9e;
            --rust: #8b4513;
            --dragon-red: #c41e3a;
            --royal-purple: #6c5ce7;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow: hidden;
            background: #000;
            font-family: 'Roboto', sans-serif;
        }

        .split-screen {
            display: flex;
            height: 100vh;
        }

        .left-column {
            width: 35%;
            background: #1a1a2c;
            position: relative;
            overflow: hidden;
        }

        .right-column {
            width: 65%;
            background: linear-gradient(135deg, var(--royal-purple) 0%, #5346c2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estilos do Escudo 3D */
        .shield-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            perspective: 1000px;
        }

        .shield-3d {
            width: 300px;
            height: 400px;
            position: relative;
            transform-style: preserve-3d;
            animation: float 6s ease-in-out infinite;
        }

        .shield-body {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--metal-dark), var(--metal-mid));
            clip-path: polygon(0% 15%, 15% 0%, 85% 0%, 100% 15%, 100% 85%, 85% 100%, 15% 100%, 0% 85%);
            border-radius: 15px;
            transform: translateZ(20px);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
        }

        .shield-border {
            position: absolute;
            width: 110%;
            height: 110%;
            background: linear-gradient(45deg, var(--rust), #5a2d12);
            clip-path: polygon(0% 15%, 15% 0%, 85% 0%, 100% 15%, 100% 85%, 85% 100%, 15% 100%, 0% 85%);
            transform: translateZ(10px);
        }

        .shield-emblem {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            background: var(--dragon-red);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            animation: glow 3s ease-in-out infinite;
        }

        .shield-rivets {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shield-rivet {
            position: absolute;
            width: 12px;
            height: 12px;
            background: var(--metal-light);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotateX(15deg) rotateY(30deg); }
            50% { transform: translateY(-20px) rotateX(20deg) rotateY(35deg); }
        }

        @keyframes glow {
            0%, 100% { filter: drop-shadow(0 0 10px var(--dragon-red)); }
            50% { filter: drop-shadow(0 0 20px var(--dragon-red)); }
        }

        /* Estilos do Formulário */
        .rpg-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }

        .card-header {
            background: linear-gradient(45deg, var(--royal-purple), #857ddb);
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            text-align: center;
            border-bottom: none;
        }

        .form-control {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(0, 0, 0, 0.3);
            border-color: var(--royal-purple);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.25);
        }

        .btn-rpg {
            background: linear-gradient(45deg, var(--royal-purple), #a8a5e6);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-rpg:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }

        .link-rpg {
            color: #a8a5e6;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .link-rpg:hover {
            color: white;
        }

        .password-toggle {
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--dragon-red);
        }
    </style>
</head>
<body>
    <div class="split-screen">
        <div class="left-column">
            <div class="shield-container">
                <div class="shield-3d">
                    <div class="shield-border"></div>
                    <div class="shield-body">
                        <div class="shield-emblem"></div>
                        <div class="shield-rivets">
                            <div class="shield-rivet" style="top:10%; left:10%"></div>
                            <div class="shield-rivet" style="top:10%; right:10%"></div>
                            <div class="shield-rivet" style="bottom:10%; left:10%"></div>
                            <div class="shield-rivet" style="bottom:10%; right:10%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="right-column">
            <div class="rpg-card shadow-lg">
                <div class="card-header">
                    <i class="bi bi-shield-lock fs-1"></i>
                    <h3 class="mb-0 mt-2">Portal do Herói</h3>
                    <small>Entre no Reino Épico</small>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Pergaminho Mágico</label>
                            <input type="email" class="form-control" 
                                   id="email" name="email" 
                                   placeholder="merlin@reino.com">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Senha Rúnica</label>
                            <div class="input-group">
                                <input type="password" class="form-control" 
                                       id="password" name="password" 
                                       placeholder="••••••••">
                                <span class="input-group-text password-toggle" onclick="togglePassword()">
                                    <i id="eyeIcon" class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-rpg w-100 py-3">
                            <i class="bi bi-door-open me-2"></i>Acessar o Portal
                        </button>

                        <div class="mt-4 text-center">
                            <a href="{{ route('register') }}" class="link-rpg">
                                <i class="bi bi-person-plus me-2"></i>Novo Aventureiro?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }

        // Interatividade 3D com movimento do mouse
        const shield = document.querySelector('.shield-3d');
        document.addEventListener('mousemove', (e) => {
            const x = (window.innerWidth / 2 - e.pageX) / 30;
            const y = (window.innerHeight / 2 - e.pageY) / 30;
            shield.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>