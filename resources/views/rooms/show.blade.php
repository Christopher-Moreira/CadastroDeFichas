<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Dados RPG - Gerenciador de Campanha</title>
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
            overflow-x: hidden;
        }

        .user-panel {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 80px;
            background: var(--dark-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }

        .user-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), #857ddb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0,0,0,0.2);
        }

        .user-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.3);
        }

        .character-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .character-list {
            position: fixed;
            left: 80px;
            top: 0;
            bottom: 0;
            width: 250px;
            background: #ffffff;
            z-index: 999;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 1rem;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .character-list.show {
            transform: translateX(0);
        }

        .dice-container {
            margin-left: 80px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
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
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            color: var(--dark-color);
            border: 2px solid var(--primary-color);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .dice-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 10px rgba(0,0,0,0.15);
            background: var(--secondary-color);
            color: white;
        }

        .dice-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .dice-result-container {
            position: relative;
            width: 300px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 1000px;
        }

        .dice-3d {
            width: 100px;
            height: 100px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 1.5s ease;
            display: none;
        }

        .dice-3d.active {
            display: block;
        }

        .face {
            position: absolute;
            width: 100px;
            height: 100px;
            background: white;
            border: 2px solid var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5em;
            font-weight: bold;
            color: var(--primary-color);
            box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
        }

        .face-1 { transform: translateZ(50px); }
        .face-2 { transform: rotateY(180deg) translateZ(50px); }
        .face-3 { transform: rotateY(90deg) translateZ(50px); }
        .face-4 { transform: rotateY(-90deg) translateZ(50px); }
        .face-5 { transform: rotateX(90deg) translateZ(50px); }
        .face-6 { transform: rotateX(-90deg) translateZ(50px); }

        .simple-dice {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: white;
            border: 4px solid var(--primary-color);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .simple-dice.active {
            display: flex;
        }

        .dice-type {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .dice-result {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--dark-color);
        }

        .simple-dice.spin {
            animation: simpleSpin 1s ease-out;
        }

        @keyframes simpleSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(1080deg); }
        }

        .result-display {
            font-size: 3rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-top: 2rem;
            text-align: center;
            min-height: 80px;
        }

        .result-history {
            margin-top: 2rem;
            background: rgba(255,255,255,0.8);
            padding: 1rem;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            max-height: 200px;
            overflow-y: auto;
        }
                </style>
         </head>
    <body>
    

            <div class="dice-container">
                <h2 class="mb-4 text-center">Sistema de Dados RPG</h2>
                
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
                
                <div class="result-display" id="result-display"></div>
                
                <button class="btn btn-primary btn-lg mt-3" id="roll-btn">
                    <i class="bi bi-dice-5"></i> Rolar Dado
                </button>
                
                <div class="result-history">
                    <h6>Histórico de Rolagens</h6>
                    <div id="history-list"></div>
                </div>
            </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const diceButtons = document.querySelectorAll('.dice-btn');
            const rollButton = document.getElementById('roll-btn');
            const dice3D = document.querySelector('.dice-3d');
            const simpleDice = document.querySelector('.simple-dice');
            const diceTypeDisplay = document.querySelector('.dice-type');
            const diceResultDisplay = document.querySelector('.dice-result');
            const resultDisplay = document.getElementById('result-display');
            const historyList = document.getElementById('history-list');
            
            let activeDice = 6;
            let isRolling = false;

            diceButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (isRolling) return;
                    
                    diceButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    activeDice = parseInt(btn.dataset.dice);
                    updateDiceDisplay();
                });
            });

            rollButton.addEventListener('click', rollDice);

            function updateDiceDisplay() {
                if (activeDice === 6) {
                    dice3D.classList.add('active');
                    simpleDice.classList.remove('active');
                } else {
                    dice3D.classList.remove('active');
                    simpleDice.classList.add('active');
                    diceTypeDisplay.textContent = `D${activeDice}`;
                }
            }

            function rollDice() {
                if (isRolling) return;
                isRolling = true;
                
                const result = Math.floor(Math.random() * activeDice) + 1;
                
                if (activeDice === 6) {
                    animate3DDice(result);
                } else {
                    animateSimpleDice(result);
                }

                setTimeout(() => {
                    showResult(result);
                    addToHistory(result);
                    isRolling = false;
                }, 1500);
            }

            function animate3DDice(result) {
                const rotations = {
                    1: { x: 0, y: 0 },
                    2: { x: 180, y: 0 },
                    3: { x: 90, y: 0 },
                    4: { x: -90, y: 0 },
                    5: { x: 0, y: 90 },
                    6: { x: 0, y: -90 }
                };
                
                const randomRotations = {
                    x: Math.floor(Math.random() * 5) * 360,
                    y: Math.floor(Math.random() * 5) * 360
                };

                dice3D.style.transform = `
                    rotateX(${rotations[result].x + randomRotations.x}deg)
                    rotateY(${rotations[result].y + randomRotations.y}deg)
                `;
            }

            function animateSimpleDice(result) {
                simpleDice.classList.remove('spin');
                void simpleDice.offsetWidth;
                simpleDice.classList.add('spin');
                diceResultDisplay.textContent = result;
            }

            function showResult(result) {
                resultDisplay.textContent = `Resultado: ${result}`;
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