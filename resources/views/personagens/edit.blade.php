<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Ficha de Personagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
       body {
            background-image: url('{{ asset('storage/fichas/ficha100.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #ffffff;
        }   
        .card {
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
            padding: 5px 10px;
            border-radius: 4px;
            min-width: 40px;
            text-align: center;
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
        #image-preview {
            transition: transform 0.3s ease;
        }
        #image-preview:hover {
            transform: scale(1.05);
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
        <div class="card shadow" 
             style="background-image: url('{{ asset('storage/fichas/sanidade100.png') }}');
                    background-size: cover;
                    background-position: center;
                    background-color: rgba(26, 26, 26, 0.8);
                    background-blend-mode: multiply;">
            
            <div class="card-header" style="background-color: rgba(102, 85, 85, 0.8);">
                <h3 class="mb-0 text-white">Editar Ficha de Personagem</h3>
            </div>
            
            <div class="card-body" style="background-color: rgba(26, 26, 26, 0.7);">
                <form method="POST" action="{{ route('personagens.update', $personagem->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Seção de Imagem -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mb-3" style="background-color: rgba(0, 0, 0, 0.5);">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0">Imagem do Personagem</h6>
                                </div>
                                <div class="card-body text-center">
                                    @if($personagem->imagens)
                                        <img id="image-preview" src="{{ asset('storage/' . $personagem->imagens) }}" 
                                            class="img-fluid mb-2 border rounded upload-hover" 
                                            style="max-width: 200px; height: auto;">
                                    @else
                                        <img id="image-preview" src="https://via.placeholder.com/200x200" 
                                            class="img-fluid mb-2 border rounded upload-hover" 
                                            style="max-width: 200px; height: auto;">
                                    @endif
                                    
                                    <input type="file" 
                                        id="imagem" 
                                        name="imagens" 
                                        class="form-control d-none" 
                                        accept="image/*"
                                        onchange="previewImage(event)">
                                    
                                    <button type="button" 
                                            class="btn btn-primary mt-2" 
                                            onclick="document.getElementById('imagem').click()">
                                        <i class="bi bi-upload"></i> Alterar Imagem
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Informações Básicas -->
                        <div class="col-md-9">
                            <div class="mb-4">
                                <h5 class="mb-3"><i class="bi bi-person-badge"></i> Informações Básicas</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Nome do Personagem</label>
                                        <input type="text" class="form-control" name="personagem_nome" value="{{ $personagem->personagem_nome }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Vida</label>
                                        <input type="number" id="vida" class="form-control" name="vida" min="0" value="{{ $personagem->vida }}" max="100" oninput="updateHealthBar()">
                                        <div class="health-bar mt-2">
                                            <div id="health-bar-inner" class="health-bar-inner"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Sanidade</label>
                                        <div class="attribute-group">
                                            <input type="number" class="form-control attribute-input" name="sanidade" min="0" max="100" value="{{ $personagem->sanidade }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Nível</label>
                                        <input type="number" class="form-control" name="level" min="1" value="{{ $personagem->level }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">XP</label>
                                        <input type="number" class="form-control" name="xp" min="0" value="{{ $personagem->xp }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Idade</label>
                                        <input type="number" class="form-control" name="idade" value="{{ $personagem->idade }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Características Físicas -->
                            <div class="mb-4">
                                <h5 class="mb-3"><i class="bi bi-body-text"></i> Características Físicas</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Cor dos Olhos</label>
                                        <input type="text" class="form-control" name="cor_olhos" value="{{ $personagem->cor_olhos }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Cabelo</label>
                                        <input type="text" class="form-control" name="cabelo" value="{{ $personagem->cabelo }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Altura (cm)</label>
                                        <input type="number" class="form-control" name="altura" value="{{ $personagem->altura }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Descrição e História -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-book"></i> Descrição e História</h5>
                        <div class="mb-3">
                            <label class="form-label">Descrição Física</label>
                            <textarea class="form-control" name="descricao" rows="3">{{ $personagem->descricao }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">História (Lore)</label>
                            <textarea class="form-control" name="lore" rows="3">{{ $personagem->lore }}</textarea>
                        </div>
                    </div>

                    <!-- Atributos -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-shield-shaded"></i> Atributos</h5>
                        <div class="row g-3">
                            @foreach ([
                                ['name' => 'forca', 'label' => 'Força', 'value' => $personagem->forca],
                                ['name' => 'coragem', 'label' => 'Coragem', 'value' => $personagem->coragem],
                                ['name' => 'fe', 'label' => 'Fé', 'value' => $personagem->fe],
                                ['name' => 'agilidade', 'label' => 'Agilidade', 'value' => $personagem->agilidade],
                                ['name' => 'furtividade', 'label' => 'Furtividade', 'value' => $personagem->furtividade],
                                ['name' => 'resistencia', 'label' => 'Resistência', 'value' => $personagem->resistencia],
                                ['name' => 'carisma', 'label' => 'Carisma', 'value' => $personagem->carisma],
                                ['name' => 'inteligencia', 'label' => 'Inteligência', 'value' => $personagem->inteligencia],
                                ['name' => 'percepcao', 'label' => 'Percepção', 'value' => $personagem->percepcao]
                            ] as $attr)
                            <div class="col-md-3">
                                <label class="form-label">{{ $attr['label'] }}</label>
                                <div class="attribute-group">
                                    <input type="number" class="form-control attribute-input" 
                                           name="{{ $attr['name'] }}" 
                                           min="0" 
                                           max="20" 
                                           value="{{ $attr['value'] }}">
                                    <div class="modifier-square" data-for="{{ $attr['name'] }}">
                                        @php
                                            $modifier = 
                                                $attr['value'] == 0 ? -2 :
                                                ($attr['value'] == 1 ? -1 :
                                                ($attr['value'] >= 2 && $attr['value'] <= 3 ? 0 :
                                                ($attr['value'] >= 4 && $attr['value'] <= 5 ? +1 : +2)));
                                            echo $modifier >= 0 ? "+$modifier" : $modifier;
                                        @endphp
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Inventário -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-backpack"></i> Inventário</h5>
                        <textarea class="form-control" name="mochila" rows="3">{{ $personagem->mochila }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('pagina.principal') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Atualizar Personagem</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Health Bar
        function updateHealthBar() {
            const vida = document.getElementById('vida').value;
            const healthBar = document.getElementById('health-bar-inner');
            const percentage = (vida / 100) * 100;
            
            healthBar.style.width = `${percentage}%`;
            healthBar.style.backgroundColor = 
                percentage > 50 ? 'green' :
                percentage > 25 ? 'yellow' : 'red';
        }
        updateHealthBar();

        // Modifiers Calculation
        function calculateModifier(value) {
            value = parseInt(value) || 0;
            if (value === 0) return -2;
            if (value === 1) return -1;
            if (value >= 2 && value <= 3) return 0;
            if (value >= 4 && value <= 5) return +1;
            return +2;
        }

        function updateModifiers() {
            document.querySelectorAll('.attribute-input').forEach(input => {
                const modifier = calculateModifier(input.value);
                const square = document.querySelector(`[data-for="${input.name}"]`);
                square.textContent = modifier >= 0 ? `+${modifier}` : modifier;
                square.style.backgroundColor = 
                    modifier === -2 ? '#ff9999' :
                    modifier === -1 ? '#ffcc99' :
                    modifier === 0 ? '#e9ecef' :
                    modifier === +1 ? '#b3ffb3' : '#99ccff';
            });
        }

        // Image Preview
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('image-preview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Event Listeners
        document.querySelectorAll('.attribute-input').forEach(input => {
            input.addEventListener('input', updateModifiers);
        });
        updateModifiers();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>