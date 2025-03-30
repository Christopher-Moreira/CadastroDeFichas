<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RPG - Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .profile-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .create-btn {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .create-btn:hover {
            transform: translate(-50%, -50%) scale(1.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Conteúdo Principal -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body" style="height: 80vh;">
                        <button onclick="window.location.href='{{ route('personagens.create') }}'" class="btn btn-primary create-btn">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                        <div class="text-center mt-5 pt-5">
                            <small class="text-muted">Clique no botão + para criar uma nova ficha</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barra Lateral -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Perfil do Usuário -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="profile-circle me-3">
                                <i class="bi bi-person-fill text-secondary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                <small class="text-muted">Jogador</small>
                            </div>
                        </div>

                        <!-- Lista de Fichas -->
                        <!-- Lista de Fichas -->
<h6 class="mb-3">Minhas Fichas</h6>
<div class="list-group">
    @forelse ($personagens as $personagem)
    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <div>
            <strong>{{ $personagem->personagem_nome }}</strong>
            <div class="text-muted small">
                <span class="badge bg-primary me-1">Nível {{ $personagem->level }}</span>
                <span>{{ $personagem->classe ?? 'Sem classe' }}</span>
            </div>
        </div>
        <i class="bi bi-chevron-right"></i>
    </a>
    @empty
    <div class="list-group-item text-muted">
        Nenhuma ficha encontrada. Clique no + para criar uma nova!
    </div>
    @endforelse
</div>

                        <!-- Logout -->
                        <div class="mt-4 pt-3 border-top">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-box-arrow-left me-2"></i>Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
