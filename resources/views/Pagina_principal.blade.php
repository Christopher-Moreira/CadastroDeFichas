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

        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-radius: 15px 15px 0 0;
        }

        #confirmDelete {
            transition: all 0.2s ease;
        }

        #confirmDelete:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4);
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
                        <h6 class="mb-3">Minhas Fichas</h6>
                        <div class="list-group">
                            @forelse ($personagens as $personagem)
                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <a href="{{ route('personagens.edit', ['personagem' => $personagem->id]) }}" class="text-decoration-none flex-grow-1">
                                    <div>
                                        <strong>{{ $personagem->personagem_nome }}</strong>
                                        <div class="text-muted small">
                                            <span class="badge bg-primary me-1">Nível {{ $personagem->level }}</span>
                                            <span>Vida {{ $personagem->vida }}%</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="d-flex align-items-center">
                                    <form method="POST" action="{{ route('personagens.destroy', $personagem->id) }}" class="me-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-link text-danger p-0" data-bs-toggle="delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <i class="bi bi-chevron-right"></i>
                                </div>
                            </div>
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

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-2 fs-4"></i>
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmar exclusão</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-0">Tem certeza que deseja excluir esta ficha permanentemente?</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            let deleteForm = null;

            document.querySelectorAll('[data-bs-toggle="delete"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    deleteForm = this.closest('form');
                    modal.show();
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