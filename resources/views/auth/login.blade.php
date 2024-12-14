<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>SIABSENSI PRATAMA</title>
    <meta name="description" content="Sistem Absensi Modern">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        :root {
            --primary-color: #2196F3;
            --secondary-color: #2196F3;
            --text-color: #333;
            --text-muted: #666;
            --bg-color: #f5f5f5;
            --input-bg: #ffffff;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        body {
            background: var(--bg-color);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #appCapsule {
            width: 100%;
            max-width: 480px;
            margin: 2rem;
            display: flex;
            justify-content: center;
        }

        .login-form {
            width: 100%;
            padding: 2.5rem;
            background: var(--input-bg);
            border-radius: 24px;
            box-shadow: 0 12px 24px var(--shadow-color);
        }

        .form-image {
            width: 140px;
            height: auto;
            display: block;
            margin: 0 auto 2rem;
            animation: gentleBounce 6s ease-in-out infinite;
        }

        @keyframes gentleBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .section {
            margin-bottom: 2.5rem;
        }

        .section h1 {
            color: var(--text-color);
            font-size: 1.75rem;
            font-weight: 700;
            text-align: center;
            margin: 0 0 0.75rem 0;
            line-height: 1.2;
        }

        .section h4 {
            color: var(--text-muted);
            text-align: center;
            font-size: 1rem;
            margin: 0;
            font-weight: 500;
            line-height: 1.4;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--text-muted);
            font-size: 1.25rem;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            height: 3.5rem;
            padding: 0 3rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--input-bg);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
            outline: none;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .form-links {
            text-align: right;
            margin: 1rem 0 1.5rem;
        }

        .form-links a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            font-size: 0.9rem;
        }

        .form-links a:hover {
            color: var(--primary-color);
        }

        .btn-primary {
            width: 100%;
            height: 3.5rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(76, 175, 80, 0.2);
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            font-size: 0.9rem;
            line-height: 1.4;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-1rem);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        #loader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            #appCapsule {
                margin: 1rem;
            }

            .login-form {
                padding: 1.5rem;
            }

            .form-image {
                width: 120px;
                margin-bottom: 1.5rem;
            }

            .section {
                margin-bottom: 2rem;
            }

            .section h1 {
                font-size: 1.5rem;
            }

            .section h4 {
                font-size: 0.9rem;
            }

            .form-control {
                height: 3rem;
            }

            .btn-primary {
                height: 3rem;
            }
        }
    </style>
</head>

<body>
    <!-- Loader/Spinner untuk loading -->
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <!-- Container Utama -->
    <div id="appCapsule">
        <div class="login-form">
            <div class="section">
                <img src="{{ asset('assets/img/login/gambar1.png') }}" alt="Logo Perusahaan" class="form-image">
                <h1>SIABSENSI PRATAMA</h1>
                <h4>Selamat Datang Kembali</h4>
            </div>

            <!-- Pesan Peringatan -->
            @if(Session::has('warning'))
            <div class="alert">
                {{ Session::get('warning') }}
            </div>
            @endif

            <!-- Form Login -->
            <form action="/proseslogin" method="POST" id="loginForm">
                @csrf
                <div class="form-group">
                    <div class="input-wrapper">
                        <ion-icon name="person-outline" class="input-icon"></ion-icon>
                        <input type="text"
                               name="nik"
                               class="form-control"
                               id="nik"
                               placeholder="Masukkan NIK"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <ion-icon name="lock-closed-outline" class="input-icon"></ion-icon>
                        <input type="password"
                               class="form-control"
                               id="password"
                               name="password"
                               placeholder="Masukkan Kata Sandi"
                               required>
                        <ion-icon name="eye-outline"
                                 class="password-toggle"
                                 id="passwordToggle">
                        </ion-icon>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Masuk</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi toggle kata sandi
            const passwordToggle = document.getElementById('passwordToggle');
            const passwordInput = document.getElementById('password');

            if (passwordToggle && passwordInput) {
                passwordToggle.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    passwordToggle.setAttribute('name', type === 'password' ? 'eye-outline' : 'eye-off-outline');
                });
            }

            // Fungsi submit form
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    document.getElementById('loader').style.display = 'flex';
                });
            }

            // Sembunyikan loader setelah halaman dimuat
            window.addEventListener('load', function() {
                const loader = document.getElementById('loader');
                if (loader) {
                    loader.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
