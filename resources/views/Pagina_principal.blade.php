<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RPG Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a8a5e6;
            --accent-color: #ff7675;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg,rgb(223, 223, 223) 0%,rgb(146, 146, 146) 100%);
            min-height: 100vh;
        }

        .profile-card {
            background: linear-gradient(45deg, var(--primary-color), #857ddb);
            border-radius: 15px;
            color: white;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
        }

        .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .create-btn {
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            border: none;
            box-shadow: 0 8px 20px rgba(108, 92, 231, 0.3);
            transition: all 0.3s ease;
        }

        .create-btn:hover {
            transform: scale(1.1) rotate(90deg);
            background: var(--primary-color);
            box-shadow: 0 12px 25px rgba(108, 92, 231, 0.4);
        }

        .character-card {
            background: white;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .character-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: var(--secondary-color);
        }

        .health-bar {
            height: 6px;
            border-radius: 3px;
            background: #eee;
            overflow: hidden;
        }

        .health-progress {
            height: 100%;
            background: linear-gradient(90deg,rgb(126, 216, 126),rgba(18, 153, 97, 0.48));
            transition: width 0.5s ease;
        }

        .level-badge {
            background: var(--accent-color);
            color: white;
            border-radius: 20px;    
            padding: 4px 12px;
            font-size: 0.8rem;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .logout-btn {
            background: rgba(255, 118, 117, 0.1);
            color: var(--accent-color);
            border: 2px solid var(--accent-color);
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: var(--accent-color);
            color: white;
        }

        .empty-state {
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .empty-state:hover {
            opacity: 0.8;
        }

        .character-list-container {
            max-height: 315px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) rgba(0,0,0,0.1);
        }

        .character-list-container::-webkit-scrollbar {
            width: 8px;
        }

        .character-list-container::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .character-list-container::-webkit-scrollbar-thumb {
            background-color: var(--primary-color);
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-5">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="profile-card mb-4">
                    <div class="d-flex align-items-center">
                        <div class="profile-pic me-3">
                            <i class="bi bi-dice-5"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                                <small class="opacity-75">Roleplayer</small>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex flex-column">
                        <h5 class="mb-3 fw-bold text-primary">Personagens</h5>
                        
                        <!-- Botão de Criar Personagem com novo ícone -->
                        <div class="text-center mb-4">
                            <button onclick="window.location.href='{{ route('personagens.create') }}'" 
                                class="btn btn-primary create-btn rounded-circle">
                                <i class="bi bi-person-plus fs-1"></i>
                            </button>
                            <p class="text-muted mt-2">Criar Novo Personagem</p>
                        </div>

                        <!-- Container da lista com scroll -->
                        <div class="character-list-container flex-grow-1">
                            <div class="list-group list-group-flush">
                                @forelse ($personagens as $personagem)
                                <div class="list-group-item character-card p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0 fw-bold">{{ $personagem->personagem_nome }}</h6>
                                                <span class="level-badge">Nv. {{ $personagem->level }}</span>
                                            </div>
                                            <div class="health-bar">
                                                <div class="health-progress" style="width: {{ $personagem->vida }}%"></div>
                                            </div>
                                        </div>
                                        <div class="ms-3 d-flex gap-2">
                                            <button onclick="window.location.href='{{ route('personagens.edit', $personagem->id) }}'" 
                                                class="btn btn-link text-primary p-0">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('personagens.destroy', $personagem->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-link text-danger p-0" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#confirmationModal">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                             </div>
                                                @empty
                                                <div class="text-center py-4 empty-state">
                                                    <i class="bi bi-journal-x fs-1"></i>
                                                    <p class="mt-2 mb-0">Nenhum personagem criado</p>
                                                </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-2">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="btn logout-btn w-100 fw-bold">
                                                    <i class="bi bi-box-arrow-left me-2"></i>Sair da Aventura
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Conteúdo Principal -->
                            <div class="col-lg-8">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body d-flex flex-column justify-content-center">
                                        <div class="row g-4 text-center">
                                            <!-- Botão Criar Sala -->
                                            <div class="col-md-6">
                                                <button onclick="window.location.href='{{ route('salas.sala_create') }}'"  
                                                    class="btn btn-success create-btn rounded-circle">
                                                    <i class="bi bi-plus-lg fs-1"></i>
                                                </button>
                                                <h4 class="mt-4 fw-bold text-secondary">Criar Nova Sala</h4>
                                                <p class="text-muted">Inicie uma nova aventura com seus amigos</p>
                                            </div>
                                            
                                            <!-- Botão Entrar em Sala -->
                                            <div class="col-md-6">
                                                <button onclick="window.location.href='{{ route('salas.sala_join') }}'"
                                                    class="btn btn-primary create-btn rounded-circle">
                                                    <i class="bi bi-door-open fs-1"></i>
                                                </button>
                                                <h4 class="mt-4 fw-bold text-secondary">Entrar em Sala</h4>
                                                <p class="text-muted">Junte-se a uma aventura em andamento</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de Confirmação -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center p-5">
                                    <div class="mb-4">
                                        <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
                                    </div>
                                    <h4 class="mb-3">Excluir Personagem?</h4>
                                    <p class="text-muted">Esta ação é permanente e não pode ser desfeita.</p>
                                    <div class="d-flex justify-content-center gap-3 mt-4">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-danger px-4" id="confirmDelete">Excluir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            let deleteForm = null;

            document.querySelectorAll('[data-bs-target="#confirmationModal"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    deleteForm = this.closest('form');
                });
            });

            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            });
        });
    </script>
</body>
</html>