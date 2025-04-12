<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar em Sala - RPG Manager</title>
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

        .gateway-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .runic-glyph {
            width: 100px;
            height: 100px;
            background: var(--accent-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin: 2rem auto;
            transition: transform 0.3s ease;
        }

        .runic-glyph:hover {
            transform: rotate(-15deg) scale(1.1);
        }

        .gateway-input {
            border: 3px solid var(--accent-color);
            border-radius: 15px;
            height: 60px;
            font-size: 1.25rem;
            padding: 15px 25px;
            letter-spacing: 0.5em;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .gateway-input:focus {
            box-shadow: 0 0 15px rgba(255, 118, 117, 0.3);
        }

        .btn-unseal {
            background: var(--accent-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1.25rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-unseal:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 118, 117, 0.4);
        }

        .portal-link {
            color: var(--accent-color);
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
                <div class="gateway-card p-5">
                    <div class="text-center mb-5">
                        <div class="runic-glyph">
                            <i class="bi bi-key"></i>
                        </div>
                        <h1 class="fw-bold mb-3">Desvendar Portal</h1>
                        <p class="text-muted">Insira o código rúnico de 6 caracteres</p>
                    </div>

                    <form method="POST" action="{{ route('rooms.enter') }}">
                        @csrf
                        <div class="mb-4">
                            <input type="text" 
                                   class="form-control gateway-input @error('code') is-invalid @enderror" 
                                   name="code" 
                                   placeholder="••••••"
                                   maxlength="6"
                                   required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-unseal w-100">
                            <i class="bi bi-unlock me-2"></i>Ativar Portal
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('pagina.principal') }}" class="portal-link">
                            <i class="bi bi-arrow-left me-2"></i>Retornar ao Covil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.querySelector('input[name="code"]');
        
        codeInput.addEventListener('input', function(e) {
            // Permite letras (A-Z, a-z) e números (0-9)
            this.value = this.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
            
            if(this.value.length === 6) {
                this.blur();
            }
        });

        codeInput.addEventListener('keypress', function(e) {
            const charCode = e.which || e.keyCode;
            // Permite letras (A-Z, a-z) e números (0-9)
            if(!((charCode >= 65 && charCode <= 90) || 
                 (charCode >= 97 && charCode <= 122) ||
                 (charCode >= 48 && charCode <= 57))) {
                e.preventDefault();
            }
        });
    });
</script>

</body>
</html>