<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Indoapril</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        body {
            background: linear-gradient(135deg, #CD5C5C, #CD5C5C);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
    
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-image: radial-gradient(circle, rgba(255,255,255,0.6) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: sparkle 5s linear infinite;
            pointer-events: none;
        }
        @keyframes sparkle {
            from { background-position: 0 0; }
            to { background-position: 100px 100px; }
        }
        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            opacity: 0;
            transform: translateY(-30px);
            animation: fadeInUp 1s forwards;
            transition: all 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .login-title {
            color: #CD5C5C;
            font-weight: bold;
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }
        .login-title:hover {
            color: #CD5C5C;
        }
        .btn-pink {
            background-color: #CD5C5C;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-pink:hover {
            background-color: #CD5C5C;
        }
        a.register-link {
            color: #CD5C5C;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a.register-link:hover {
            color: #CD5C5C;
        }
        /* Untuk HP kecil */
@media (max-width: 600px) {
  .content {
    padding: 20px;
    font-size: 16px;
  }

  h1 {
    font-size: 24px;
  }
}

/* Untuk tablet */
@media (min-width: 601px) and (max-width: 900px) {
  .content {
    padding: 40px;
    font-size: 18px;
  }

  h1 {
    font-size: 28px;
  }
}

/* Untuk desktop besar */
@media (min-width: 901px) {
  .content {
    padding: 60px;
    font-size: 20px;
  }

  h1 {
    font-size: 32px;
  }
}
    </style>
</head>
<body>
    <div class="login-card">
        <h2 class="text-center login-title">Login</h2>
        <p class="text-center text-muted mb-4">Silakan masuk dengan username dan password</p>
        <form method="POST" action="{{url('login')}}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
           <!-- Ganti bagian ini di dalam <div class="mb-3 position-relative"> -->
<div class="mb-3 position-relative">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
    
    <!-- SVG toggle -->
    <span class="toggle-password" onclick="togglePassword()" style="position: absolute; top: 38px; right: 15px; cursor: pointer;">
        <!-- Mata Terbuka -->
        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#CD5C5C" viewBox="0 0 24 24">
            <path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
            <circle cx="12" cy="12" r="2.5"/>
        </svg>

        <!-- Mata Tertutup -->
        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#CD5C5C" viewBox="0 0 24 24" style="display: none;">
            <path d="M2 5.27 3.28 4 20 20.72 18.73 22l-3.32-3.32C13.88 19 13 19 12 19c-7 0-11-7-11-7 1.06-1.86 2.56-3.43 4.36-4.58L2 5.27zM12 5c2.6 0 4.94 1.26 6.55 3.25l-1.42 1.42A8.472 8.472 0 0 0 12 7c-0.98 0-1.9 0.2-2.75 0.56L7.53 6.84C8.67 6.3 10.3 6 12 6V5z"/>
        </svg>
    </span>
</div>

            <button type="submit" class="btn btn-pink w-100">Login Sekarang</button>
        </form>

        @if (Session::has('pesan'))
            <div class="alert mt-3 {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                {{ Session::get('pesan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <p class="text-center mt-3" style="font-size: 0.9rem;">Terima kasih sudah mampir di halaman Indoapril kami</p>
    </div>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.style.display = 'none';
            eyeClosed.style.display = 'inline';
        } else {
            passwordInput.type = 'password';
            eyeOpen.style.display = 'inline';
            eyeClosed.style.display = 'none';
        }
    }
</script>

</body>
</html>
