<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sala de RPG: {{ $room->name }} - Código: {{ $room->code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
   <style>
    :root {
        --primary-color: #6c5ce7;
        --dice-color: #8a75ff;
        --dice-shadow: rgba(108, 92, 231, 0.4);
        --dark-color: #2d3436;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(135deg, rgb(223, 223, 223) 0%, rgb(146, 146, 146) 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }

    .navbar {
        background: linear-gradient(45deg, var(--primary-color), #857ddb);
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .card {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 12px;
        margin-bottom: 20px;
        border: none;
    }

    .card-header {
        background: linear-gradient(45deg, var(--primary-color), #857ddb);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.2rem;
    }

    .dice-container {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .dice-selection {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .dice-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--dice-color);
        color: white;
        border: none;
        box-shadow: 0 4px 12px var(--dice-shadow);
    }

    .dice-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 15px var(--dice-shadow);
    }

    .dice-btn.active {
        background: #ff7675;
        box-shadow: 0 4px 12px rgba(255, 118, 117, 0.4);
    }

    .dice-result-container {
        position: relative;
        width: 300px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        perspective: 1000px;
        margin: 2rem 0;
    }

    .dice-3d {
        width: 120px;
        height: 120px;
        position: relative;
        transform-style: preserve-3d;
        transition: transform 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .face {
        position: absolute;
        width: 100%;
        height: 100%;
        background: var(--dice-color);
        border: 3px solid #5f4ec9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5em;
        font-weight: bold;
        color: white;
        box-shadow: 
            inset 0 0 10px rgba(0,0,0,0.1),
            0 4px 12px var(--dice-shadow);
    }

    .face-1 { transform: translateZ(60px); }
    .face-2 { transform: rotateY(180deg) translateZ(60px); }
    .face-3 { transform: rotateY(90deg) translateZ(60px); }
    .face-4 { transform: rotateY(-90deg) translateZ(60px); }
    .face-5 { transform: rotateX(90deg) translateZ(60px); }
    .face-6 { transform: rotateX(-90deg) translateZ(60px); }

    .simple-dice {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: var(--dice-color);
        border: 4px solid #5f4ec9;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        box-shadow: 0 8px 20px var(--dice-shadow);
        color: white;
    }

    .dice-type {
        font-size: 1.5rem;
        margin-bottom: 5px;
    }

    .dice-result {
        font-size: 3rem;
        font-weight: bold;
    }

    .roll-btn {
        background: var(--dice-color);
        border: none;
        border-radius: 50px;
        padding: 1rem 2.5rem;
        font-size: 1.2rem;
        color: white;
        box-shadow: 0 6px 15px var(--dice-shadow);
        transition: all 0.3s ease;
    }

    .roll-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px var(--dice-shadow);
        background: #7661f1;
    }

    .result-history {
        background: rgba(255,255,255,0.9);
        border-radius: 12px;
        padding: 1.2rem;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 500px;
    }

    @keyframes diceBounce {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    @keyframes simpleSpin {
        0% { 
            transform: rotate(0deg) scale(1);
            opacity: 0.8;
        }
        50% { 
            transform: rotate(540deg) scale(1.3);
            opacity: 1;
        }
        100% { 
            transform: rotate(1080deg) scale(1);
            opacity: 0.8;
        }
    }

    .rolling {
        animation: diceBounce 0.6s ease;
    }

    .simple-dice.spin {
        animation: simpleSpin 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .character-image {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        .online-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #4CAF50;
            display: inline-block;
            margin-right: 8px;
        }
</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('pagina.principal') }}">
                <i class="bi bi-dice-6"></i> RPG Manager
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pagina.principal') }}">
                            <i class="bi bi-house-door"></i> Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-person-rolodex"></i> Sala: {{ $room->code }}
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-light me-3">{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container main-container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Sala: {{ $room->name }} <span class="badge bg-light text-dark">Código: {{ $room->code }}</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="dice-container">
                            <h4 class="mb-4 text-center">Sistema de Dados RPG</h4>
                            
                            <div class="dice-selection">
                                <div class="dice-btn active" data-dice="4">D4</div>
                                <div class="dice-btn" data-dice="6">D6</div>
                                <div class="dice-btn" data-dice="8">D8</div>
                                <div class="dice-btn" data-dice="10">D10</div>
                                <div class="dice-btn" data-dice="12">D12</div>
                                <div class="dice-btn" data-dice="20">D20</div>
                                <div class="dice-btn" data-dice="100">D100</div>
                            </div>
                            
                            <div class="dice-result-container">
                                <div class="dice-3d active">
                                    <div class="face face-1">1</div>
                                    <div class="face face-2">2</div>
                                    <div class="face face-3">3</div>
                                    <div class="face face-4">4</div>
                                    <div class="face face-5">5</div>
                                    <div class="face face-6">6</div>
                                </div>
                                <div class="simple-dice">
                                    <div class="dice-type">D6</div>
                                    <div class="dice-result">0</div>
                                </div>
                            </div>
                            
                            <button class="btn roll-btn" id="roll-btn">
                                <i class="bi bi-dice-5"></i> Rolar Dado
                            </button>
                            
                            <div class="result-history mt-4">
                                <h6 class="mb-3">Histórico de Rolagens</h6>
                                <div id="history-list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-people-fill"></i> 
                            Aventureiros 
                            <span class="badge bg-light text-dark">{{ count($usersList) }}</span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush px-3">
                            @forelse ($usersList as $userData)
                                <li class="list-group-item user-list-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="online-indicator"></span>
                                        <strong>{{ $userData['user']->name }}</strong>
                                        @if($userData['user']->id == $room->user_id)
                                            <span class="badge bg-warning text-dark">Mestre</span>
                                        @endif
                                    </div>
                                    @if($userData['character'])
                                        <div class="text-end">
                                            <div class="text-muted small">{{ $userData['character']->personagem_nome }}</div>
                                            <div class="text-primary small">Nv. {{ $userData['character']->level }}</div>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Sem personagem</span>
                                    @endif
                                </li>
                            @empty
                                <li class="list-group-item">Nenhum usuário conectado.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                @php
                    $selectedCharacter = Auth::user()->personagens()->find(session('selected_character_id'));
                @endphp
                
                @if($selectedCharacter)
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person-badge"></i> Seu Personagem</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($selectedCharacter->imagens)
                                <img src="{{ asset('storage/' . $selectedCharacter->imagens) }}" 
                                     class="character-image me-3">
                            @else
                                <div class="character-placeholder me-3">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            @endif
                            <div>
                                <h5>{{ $selectedCharacter->personagem_nome }}</h5>
                                <p class="mb-0">Nível {{ $selectedCharacter->level }}</p>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <div class="text-primary fw-bold">{{ $selectedCharacter->forca }}</div>
                                    <div class="small text-muted">Força</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <div class="text-primary fw-bold">{{ $selectedCharacter->agilidade }}</div>
                                    <div class="small text-muted">Agilidade</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <div class="text-primary fw-bold">{{ $selectedCharacter->inteligencia }}</div>
                                    <div class="small text-muted">Inteligência</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <div class="text-primary fw-bold">{{ $selectedCharacter->percepcao }}</div>
                                    <div class="small text-muted">Percepção</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const diceButtons = document.querySelectorAll('.dice-btn');
        const rollButton = document.getElementById('roll-btn');
        const dice3D = document.querySelector('.dice-3d');
        const simpleDice = document.querySelector('.simple-dice');
        const diceResultDisplay = document.querySelector('.dice-result');
        const historyList = document.getElementById('history-list');
        
        let activeDice = 6;
        let isRolling = false;

        // Configuração inicial
        updateDiceDisplay();

        diceButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (isRolling) return;
                diceButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeDice = parseInt(btn.dataset.dice);
                updateDiceDisplay();
            });
        });

        rollButton.addEventListener('click', () => {
            if (!isRolling) rollDice();
        });

        function updateDiceDisplay() {
            if (activeDice === 6) {
                dice3D.style.display = 'block';
                simpleDice.style.display = 'none';
            } else {
                dice3D.style.display = 'none';
                simpleDice.style.display = 'flex';
                simpleDice.querySelector('.dice-type').textContent = `D${activeDice}`;
            }
        }

        function calculate3DRotation(result, cycles = 3) {
            const baseRotations = {
                1: { x: 0, y: 0 },
                2: { x: 180, y: 0 },
                3: { x: 90, y: 0 },
                4: { x: -90, y: 0 },
                5: { x: 0, y: 90 },
                6: { x: 0, y: -90 }
            };

            return {
                x: baseRotations[result].x + (360 * cycles),
                y: baseRotations[result].y + (360 * cycles)
            };
        }

        function animateAllDice() {
            diceButtons.forEach(btn => {
                btn.classList.add('rolling');
                setTimeout(() => btn.classList.remove('rolling'), 600);
            });
        }

        function rollDice() {
            isRolling = true;
            animateAllDice();
            
            const result = Math.floor(Math.random() * activeDice) + 1;
            
            if (activeDice === 6) {
                const rotation = calculate3DRotation(result);
                dice3D.style.transform = `
                    rotateX(${rotation.x}deg)
                    rotateY(${rotation.y}deg)
                `;
            } else {
                simpleDice.querySelector('.dice-result').textContent = result;
                simpleDice.classList.add('spin');
            }

            setTimeout(() => {
                addToHistory(result);
                isRolling = false;
                if (activeDice !== 6) {
                    simpleDice.classList.remove('spin');
                }
            }, 1500);
        }

        function addToHistory(result) {
            const now = new Date();
            const time = `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
            
            const historyItem = document.createElement('div');
            historyItem.className = 'd-flex justify-content-between py-2';
            historyItem.innerHTML = `
                <span>D${activeDice}: <strong>${result}</strong></span>
                <small class="text-muted">${time}</small>
            `;
            historyList.prepend(historyItem);
            
            if (historyList.children.length > 10) {
                historyList.lastChild.remove();
            }
        }
    });
</script>
</body>
</html>