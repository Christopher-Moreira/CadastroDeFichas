<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Sala - RPG Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a8a5e6;
            --accent-color: #ff7675;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, rgb(223, 223, 223) 0%, rgb(146, 146, 146) 100%);
            min-height: 100vh;
        }

        .creation-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .runic-portal {
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

        .runic-portal:hover {
            transform: rotate(15deg) scale(1.1);
        }

        .portal-input {
            border: 3px solid var(--primary-color);
            border-radius: 15px;
            height: 60px;
            font-size: 1.25rem;
            padding: 15px 25px;
            transition: all 0.3s ease;
        }

        .portal-input:focus {
            box-shadow: 0 0 15px rgba(108, 92, 231, 0.3);
        }

        .btn-enchant {
            background: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1.25rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-enchant:hover {
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row min-vh-100 align-items-center">
            <div class="col-md-8 col-lg-6 mx-auto">
                <div class="creation-card p-5">
                    <div class="text-center mb-5">
                        <div class="runic-portal">
                            <i class="bi bi-stars"></i>
                        </div>
                        <h1 class="fw-bold mb-3">Forjar Nova Dimensão</h1>
                        <p class="text-muted">Dê um nome ao seu reino de aventuras</p>
                    </div>

                    <form method="POST" action="{{ route('rooms.store') }}">
                        @csrf
                        <div class="mb-4">
                            <input type="text" 
                                   class="form-control portal-input @error('name') is-invalid @enderror" 
                                   name="name" 
                                   placeholder="Nome da Dimensão"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-enchant w-100">
                            <i class="bi bi-magic me-2"></i>Conjurar Realidade
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('pagina.principal') }}" class="portal-link">
                            <i class="bi bi-arrow-left me-2"></i>Voltar ao Covil Principal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>