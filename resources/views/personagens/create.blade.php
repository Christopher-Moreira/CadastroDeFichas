<!-- resources/views/personagens/create.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Ficha de Personagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Nova Ficha de Personagem</h3>
            </div>
            
            <div class="card-body">
                <form method="POST" action="{{ route('personagens.store') }}">
                    @csrf

                    <!-- Seção: Informações Básicas -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-person-badge"></i> Informações Básicas</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome do Personagem</label>
                                <input type="text" class="form-control" name="personagem_nome" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Nível</label>
                                <input type="number" class="form-control" name="level" min="1" value="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Idade</label>
                                <input type="number" class="form-control" name="idade" min="1">
                            </div>
                        </div>
                    </div>

                    <!-- Seção: Características Físicas -->
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

                    <!-- Seção: Descrição e História -->
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

                    <!-- Seção: Atributos -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-shield-shaded"></i> Atributos</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Vida</label>
                                <input type="number" class="form-control" name="vida" min="0" value="10">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Força</label>
                                <input type="number" class="form-control" name="forca" min="0" max="20">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Coragem</label>
                                <input type="number" class="form-control" name="coragem" min="0" max="20">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fé</label>
                                <input type="number" class="form-control" name="fe" min="0" max="20">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Agilidade</label>
                                <input type="number" class="form-control" name="agilidade" min="0" max="20">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Furtividade</label>
                                <input type="number" class="form-control" name="furtividade" min="0" max="20">
                            </div>
                            <!-- Resistência -->
<div class="col-md-3">
    <label class="form-label">Resistência</label>
    <input 
        type="number" 
        class="form-control" 
        name="resistencia" 
        min="0" 
        max="20"
        required
    >
</div>

<!-- Carisma -->
<div class="col-md-3">
    <label class="form-label">Carisma</label>
    <input 
        type="number" 
        class="form-control" 
        name="carisma" 
        min="0" 
        max="20"
        required
    >
</div>

<!-- Inteligência -->
<div class="col-md-3">
    <label class="form-label">Inteligência</label>
    <input 
        type="number" 
        class="form-control" 
        name="inteligencia" 
        min="0" 
        max="20"
        required
    >
</div>

<!-- Percepção -->
<div class="col-md-3">
    <label class="form-label">Percepção</label>
    <input 
        type="number" 
        class="form-control" 
        name="percepcao" 
        min="0" 
        max="20"
        required
    >
</div>

<!-- Sanidade -->
<div class="col-md-3">
    <label class="form-label">Sanidade</label>
    <input 
        type="number" 
        class="form-control" 
        name="sanidade" 
        min="0" 
        max="100" 
        value="100"
        required
    >
</div>
                        </div>
                    </div>

                    <!-- Seção: Inventário e Sanidade -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>