<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .login-container {
            width: 100%;
            height: 100%;
            background: #fff;
            /* border-radius: 10px; */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            overflow: hidden;
        }
        .left-section {
            position: relative; /* Required for ::before positioning */
            background-image: url('{{ asset('images/smkn4.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 40px 30px;
            display: flex;
            align-items: flex-end;
            width: 50%;
            color: #fff; /* White text for readability */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Text shadow for contrast */
        }
        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.32); /* Semi-transparent black overlay */
            z-index: 1; /* Place overlay above background image */
        }
        .judul {
            position: relative; /* Ensure text is above overlay */
            z-index: 2; /* Place text above ::before overlay */
        }
        .judul h5 {
            font-size: 1.2rem;
            margin-top: 10px;
            color :rgb(243, 243, 243)
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
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .left-section, .right-section {
                width: 100%;
            }
            .left-section {
                padding: 20px;
                min-height: 200px; /* Ensure visibility on mobile */
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Section: SMK Background Image and Name -->
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
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <a href="" class="forgot-password mb-3">Lupa Password?</a>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (Optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
