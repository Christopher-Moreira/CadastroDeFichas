<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Ficha de Personagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>

        
        body {
                background-color: black;
                color: #ffffff; /* White text for better contrast */
            }
            .card {
                background-color: #1a1a1a; /* Dark card background */
                color: #ffffff;
            }
            .form-control {
                background-color: #2d2d2d;
                color: #ffffff;
                border: 1px solid #3d3d3d;
            }
            .form-control:focus {
                background-color: #3d3d3d;
                color: #ffffff;
                border-color: #4d4d4d;
            }
            .modifier-square {
                background-color: #333333;
                border-color: #444444;
            }

                .health-bar {
                    width: 100%;
                    height: 20px;
                    background-color: #ddd;
                    border-radius: 5px;
                    overflow: hidden;
                    position: relative;
                }
                .health-bar-inner {
                    height: 100%;
                    width: 100%;
                    background-color: green;
                    transition: width 0.3s, background-color 0.3s;
                }
                .attribute-group {
                    display: flex;  
                    align-items: center;
                    gap: 10px;
                }
                .modifier-square {
                    width: 40px;
                    height: 40px;
                    background-color: #e9ecef;
                    border: 2px solid #dee2e6;
                    border-radius: 5px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    font-size: 1.2em;
                }
                #image-preview {
            transition: transform 0.3s ease;
        }

        #image-preview:hover {
            transform: scale(1.05);
        }

        .upload-hover {
            position: relative;
        }

        .upload-hover::after {
            content: "Alterar Imagem";
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .upload-hover:hover::after {
            opacity: 1;
        }


            </style>
        </head>
        <body>
            <div class="container py-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Nova Ficha de Personagem</h3>
                    </div>
                    
                    <div class="card-body">
                    
                        <form method="POST" action="{{ route('personagens.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Seção de Imagem -->
                            <div class="row mb-4">
                                <!-- Coluna da Imagem -->
                          
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Imagem do Personagem</h6>
                </div>
                <div class="card-body text-center">
                    <!-- Preview da Imagem -->
                    <img id="image-preview" src="https://via.placeholder.com/200x200" 
                        class="img-fluid mb-2 border rounded upload-hover" 
                        style="max-width: 200px; height: auto;">
                    
                    <!-- Input de Upload (mantido oculto) -->
                    <input type="file" 
                        id="imagem" 
                        name="imagens" 
                        class="form-control d-none" 
                        accept="image/*"
                        onchange="previewImage(event)">
                    
                    <!-- Botão de upload personalizado -->
                    <button type="button" 
                            class="btn btn-primary mt-2" 
                            onclick="document.getElementById('imagem').click()">
                        <i class="bi bi-upload"></i> Adicionar Imagem
                    </button>
                </div>
            </div>
        </div>

                        <!-- Coluna das Informações Básicas -->
                        <div class="col-md-9">
                            <div class="mb-4">
                                <h5 class="mb-3"><i class="bi bi-person-badge"></i> Informações Básicas</h5>
                                <div class="row g-3">
                                    <!-- Campos existentes mantidos aqui -->
                                    <div class="col-md-4">
                                        <label class="form-label">Nome do Personagem</label>
                                        <input type="text" class="form-control" name="personagem_nome" required>
                                    </div>
                        <div class="col-md-2">
                            <label class="form-label">Vida</label>
                            <input type="number" id="vida" class="form-control" name="vida" min="0" value="100" max="1000" oninput="updateHealthBar()">
                            <div class="health-bar mt-2">
                                <div id="health-bar-inner" class="health-bar-inner"></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sanidade</label>
                            <div class="attribute-group">
                                <input type="number" class="form-control attribute-input" name="sanidade" min="0" max="100" value="100" required>
                             
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Nível</label>
                            <input type="number" class="form-control" name="level" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">XP</label>
                            <input type="number" class="form-control" name="xp" min="0" value="0" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Idade</label>
                            <input type="number" class="form-control" name="idade" min="1" max "100" vale="1">
                        </div>
                    </div>
                </div>

                    <!-- Características Físicas -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-body-text"></i> Características Físicas</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Cor dos Olhos</label>
                                <input type="text" class="form-control" name="cor_olhos">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cabelo</label>
                                <input type="text" class="form-control" name="cabelo">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Altura (cm)</label>
                                <input type="number" class="form-control" name="altura">
                            </div>
                        </div>
                    </div>

                    <!-- Descrição e História -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-book"></i> Descrição e História</h5>
                        <div class="mb-3">
                            <label class="form-label">Descrição Física</label>
                            <textarea class="form-control" name="descricao" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">História (Lore)</label>
                            <textarea class="form-control" name="lore" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Atributos -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-shield-shaded"></i> Atributos</h5>
                        <div class="row g-3">
                            <!-- Column 1 -->
                            <div class="col-md-3">
                                <label class="form-label">Força</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="forca" min="0" max="20" value="0">
                                    <div class="modifier-square" data-for="forca">0</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Coragem</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="coragem" min="0" max="20" value="0">
                                    <div class="modifier-square" data-for="coragem">0</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fé</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="fe" min="0" max="20" value="0">
                                    <div class="modifier-square" data-for="fe">0</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Agilidade</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="agilidade" min="0" max="20" value="0">
                                    <div class="modifier-square" data-for="agilidade">0</div>
                                </div>
                            </div>

                            <!-- Column 2 -->
                            <div class="col-md-3">
                                <label class="form-label">Furtividade</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="furtividade" min="0" max="20" value="0">
                                    <div class="modifier-square" data-for="furtividade">0</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Resistência</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="resistencia" min="0" max="20" value="0" required>
                                    <div class="modifier-square" data-for="resistencia">0</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Carisma</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="carisma" min="0" max="20" value="0" required>
                                    <div class="modifier-square" data-for="carisma">0</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Inteligência</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="inteligencia" min="0" max="20" value="0" required>
                                    <div class="modifier-square" data-for="inteligencia">0</div>
                                </div>
                            </div>

                            <!-- Column 3 -->
                            <div class="col-md-3">
                                <label class="form-label">Percepção</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" name="percepcao" min="0" max="20" value="0" required>
                                    <div class="modifier-square" data-for="percepcao">0</div>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                    </div>

                    <!-- Inventário -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-backpack"></i> Inventário & Sanidade</h5>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Mochila (Itens)</label>
                                <textarea class="form-control" name="mochila" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('pagina.principal') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar Personagem</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Health Bar Update
        function updateHealthBar() {
            let vidaInput = document.getElementById('vida');
            let healthBarInner = document.getElementById('health-bar-inner');
            let vida = vidaInput.value;
            let percentage = (vida / 100) * 100;
            
            healthBarInner.style.width = percentage + '%';
            
            if (percentage > 50) {
                healthBarInner.style.backgroundColor = 'green';
            } else if (percentage > 25) {
                healthBarInner.style.backgroundColor = 'yellow';
            } else {
                healthBarInner.style.backgroundColor = 'red';
            }
        }

        // Attribute Modifiers Calculation
        function calculateModifier(value) {
            value = parseInt(value) || 0;
            if (value === 0) return -2;
            if (value === 1) return -1;
            if (value >= 2 && value <= 3) return 0;
            if (value >= 4 && value <= 5) return +1;
            if (value >= 6) return +2;
            return 0;
        }

        function updateModifierSquares() {
            document.querySelectorAll('.attribute-input').forEach(input => {
                const modifierValue = calculateModifier(input.value);
                const modifierSquare = document.querySelector(`[data-for="${input.name}"]`);
                if (modifierSquare) {
                    modifierSquare.textContent = modifierValue >= 0 ? `+${modifierValue}` : modifierValue;
                    
                    // Update background colors
                    modifierSquare.style.backgroundColor = 
                        modifierValue === -2 ? '#ff9999' :
                        modifierValue === -1 ? '#ffcc99' :
                        modifierValue === 0 ? '#e9ecef' :
                        modifierValue === +1 ? '#b3ffb3' :
                        '#99ccff';
                }
            });
        }

        // Event Listeners
        document.querySelectorAll('.attribute-input').forEach(input => {
            input.addEventListener('input', updateModifierSquares);
        });

        // Initial Calculation
        updateModifierSquares();

         // Preview da Imagem
    function previewImage(event) {
        const reader = new FileReader();
        const imagePreview = document.getElementById('image-preview');
        
        reader.onload = function() {
            if (reader.readyState === 2) {
                imagePreview.src = reader.result;
            }
        }
        
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>