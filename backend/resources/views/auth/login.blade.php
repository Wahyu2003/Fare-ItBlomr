<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            padding: 0;
            margin: 0;
        }
        .login-container {
            width: 100%;
            height: 100%;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            overflow: hidden;
            position: relative;
        }
        .left-section {
            position: relative;
            background-image: url('{{ asset('images/smkn4.jpg') }}'); /* Untuk pengujian: https://via.placeholder.com/450x600 */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 40px 30px;
            display: flex;
            align-items: flex-end;
            width: 50%;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .judul {
            position: relative;
            z-index: 2;
        }
        .judul h5 {
            font-size: 1.2rem;
            margin-top: 10px;
            color: rgb(243, 243, 243);
        }
        .right-section {
            padding: 0 80px;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right-section h2 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #333;
            text-align: center;
        }
        .form-control {
            border-radius: 5px;
            width: 100%;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        .forgot-password {
            display: block;
            margin-top: 10px;
            text-align: right;
            color: #696969;
            text-decoration: none;
        }
        .forgot-password:hover {
            color: red;
        }
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .input-group .btn-outline-secondary {
            border-radius: 0 5px 5px 0;
        }

        .biaye {
            background-color: #fff;
            color: #000;
            border: 1px solid #e4e3e3;
        }

        .biaye:hover {
            background-color: #c9c5c5;
            border: 1px solid #e4e3e3;
            color : white;
        }
        
        @media (max-width: 768px) {
            .biaye {
                border: none;
            }
            .biaye:hover {
                border: none;
            }

            .login-container {
                width: 100%;
                height: 100vh;
                background-image: url('{{ asset('images/smkn4.jpg') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .login-container::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1;
            }
            .left-section {
                display: none;
            }
            .right-section {
                width: 90%;
                max-width: 400px;
                padding: 20px;
                background: rgba(255, 255, 255, 0.7);
                border-radius: 10px;
                margin: auto;
                position: relative;
                z-index: 2;
            }
            .right-section h2 {
                font-size: 1.6rem;
            }
        }
        @media (max-width: 576px) {
            .right-section {
                padding: 15px;
            }
            .right-section h2 {
                font-size: 1.4rem;
            }
            .form-label {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Section: SMK Background Image and Name (Desktop Only) -->
        <div class="left-section">
            <div class="judul">
                <h1>Selamat Datang</h1>
                <h1>di SMK Negeri 4 Jember</h1>
                <h5>SMARTSCHOOL - Absensi masa depan menggunakan deteksi wajah</h5>
            </div>
        </div>

        <!-- Right Section: Login Form -->
        <div class="right-section">
            <h2>Login</h2>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required value="{{ old('username') }}">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password biaye ms-1">
                            <i class="bi bi-eye"></i>
                            <span class="border-anim"></span>
                        </button>
                    </div>
                </div>
                <a href="#" class="forgot-password mb-3">Lupa Password?</a>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript for Show/Hide Password -->
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
</body>
</html>