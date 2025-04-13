<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selecionar Personagem - RPG Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a8a5e6;
            --accent-color: #ff7675;
            --dark-color: #2d3436;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, rgb(223, 223, 223) 0%, rgb(146, 146, 146) 100%);
            min-height: 100vh;
        }

        .selection-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .mystic-emblem {
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin: 2rem auto;
            transition: transform 0.3s ease;
        }

        .mystic-emblem:hover {
            transform: rotate(15deg) scale(1.1);
        }

        .character-option {
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 1rem;
            background: rgba(255, 255, 255, 0.5);
        }

        .character-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .character-option.selected {
            border-color: var(--primary-color);
            background: rgba(108, 92, 231, 0.1);
        }

        .character-portrait {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            background: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            overflow: hidden;
        }

        .character-portrait img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .level-badge {
            background: var(--accent-color);
            color: white;
            border-radius: 20px;    
            padding: 4px 12px;
            font-size: 0.8rem;
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

        .btn-journey {
            background: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1.25rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-journey:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 92, 231, 0.4);
        }

        .portal-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .portal-link:hover {
            opacity: 0.8;
        }

        .character-list-container {
            max-height: 350px;
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

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row min-vh-100 align-items-center">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="selection-card p-5">
                    <div class="text-center mb-4">
                        <div class="mystic-emblem">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <h1 class="fw-bold mb-3">Escolher Aventureiro</h1>
                        <p class="text-muted">Selecione um personagem para aventurar-se na sala {{ $room->name }}</p>
                    </div>

                    <form id="character-form" method="POST" action="{{ route('rooms.enter_with_character', $room->code) }}">
                        @csrf
                        <input type="hidden" name="selected_character_id" id="selected_character_id">
                        
                        <div class="character-list-container mb-4">
                            @forelse ($personagens as $personagem)
                                <div class="character-option" data-id="{{ $personagem->id }}">
                                    <div class="d-flex align-items-center">
                                        <div class="character-portrait me-3">
                                            @if($personagem->imagens)
                                                <img src="{{ Storage::url($personagem->imagens) }}" alt="{{ $personagem->personagem_nome }}">
                                            @else
                                                <i class="bi bi-person"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0 fw-bold">{{ $personagem->personagem_nome }}</h5>
                                                <span class="level-badge">Nv. {{ $personagem->level }}</span>
                                            </div>
                                            <div class="health-bar">
                                                <div class="health-progress" style="width: {{ $personagem->vida }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="bi bi-journal-x fs-1 mb-3"></i>
                                    <h5>Nenhum personagem disponível</h5>
                                    <p class="text-muted">Crie um personagem antes de entrar na sala</p>
                                    <a href="{{ route('personagens.create') }}" class="btn btn-outline-primary mt-2">
                                        <i class="bi bi-person-plus me-2"></i>Criar Personagem
                                    </a>
                                </div>
                            @endforelse
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('pagina.principal') }}" class="portal-link">
                                <i class="bi bi-arrow-left me-2"></i>Voltar ao Portal
                            </a>
                            <button type="submit" class="btn-journey" id="enter-room-btn" disabled>
                                <i class="bi bi-door-open me-2"></i>Iniciar Jornada
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const characterOptions = document.querySelectorAll('.character-option');
            const selectedCharacterIdInput = document.getElementById('selected_character_id');
            const enterRoomBtn = document.getElementById('enter-room-btn');
            
            characterOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selection from all options
                    characterOptions.forEach(opt => opt.classList.remove('selected'));
                    
                    // Add selection to clicked option
                    this.classList.add('selected');
                    
                    // Set the selected character id
                    const characterId = this.dataset.id;
                    selectedCharacterIdInput.value = characterId;
                    
                    // Enable the enter button
                    enterRoomBtn.disabled = false;
                });
            });
        });
    </script>
</body>
</html>