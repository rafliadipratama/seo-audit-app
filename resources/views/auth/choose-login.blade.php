<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Login - SEO Audit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-option {
            transition: transform 0.3s ease;
        }
        .login-option:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 480px; margin: auto;">
            <h3 class="text-primary fw-bold mb-4">🔐 Pilih Jenis Login</h3>

            <div class="d-grid gap-3">
                <a href="{{ route('login.user') }}" class="btn btn-outline-primary btn-lg login-option">
                    👤 Login sebagai User
                </a>
                <a href="{{ route('login.admin') }}" class="btn btn-outline-dark btn-lg login-option">
                    🧑‍💼 Login sebagai Admin
                </a>
            </div>

            <p class="text-muted mt-4 small">Aplikasi Audit SEO untuk mendukung digitalisasi UMKM.</p>
        </div>
    </div>
</body>
</html>
