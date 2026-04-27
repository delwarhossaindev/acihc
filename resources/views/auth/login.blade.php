<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('admin/assets') }}" data-template="vertical-menu-template-free">

<head>
    <x-layouts.header-component />
    <style>
        body {
            background: linear-gradient(135deg, #6f6cff 0%, #837cf5 50%, #b8b5ff 100%);
            min-height: 100vh;
        }
        .auth-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 1.5rem 4rem rgba(0, 0, 0, 0.18);
            backdrop-filter: blur(8px);
        }
        .app-brand-text {
            font-size: 1.6rem;
            background: linear-gradient(135deg, #6f6cff 0%, #5b58cc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .app-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: -0.25rem;
            margin-bottom: 1.5rem;
            letter-spacing: 0.3px;
        }
        .form-control:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.18);
        }
        .btn-login {
            background: linear-gradient(135deg, #6f6cff 0%, #5b58cc 100%);
            border: 0;
            font-weight: 500;
            padding: 0.6rem;
            transition: transform 0.15s ease, box-shadow 0.2s ease;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 0.5rem 1rem rgba(105, 108, 255, 0.35);
        }
        .auth-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6f6cff 0%, #5b58cc 100%);
            margin: 0 auto 1rem;
            color: #fff;
            font-size: 1.6rem;
        }
        @media (max-width: 575.98px) {
            .auth-card { border-radius: 0.75rem; margin: 0.5rem; }
            .app-brand-text { font-size: 1.3rem; }
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner" style="max-width: 420px;">
                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">
                        <div class="auth-icon">
                            <i class="bx bx-shield-quarter"></i>
                        </div>

                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-text fw-bolder">ACI Healthcare</span>
                            </a>
                        </div>
                        <p class="app-subtitle">Stability Management Software</p>

                        <x-alert.alert-component />

                        <form action="{{ route('login') }}" method="POST" class="mb-3 needs-validation" role="form" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" id="email" class="form-control" name="email"
                                        placeholder="Enter your email" autofocus required />
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="••••••••••••" required />
                                    <span class="input-group-text cursor-pointer" id="togglePassword">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                            </div>

                            <div class="mb-2">
                                <button class="btn btn-primary btn-login d-grid w-100" type="submit">
                                    <i class="bx bx-log-in me-1"></i>Sign in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-layouts.footer-component />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('togglePassword');
            const pwd = document.getElementById('password');
            if (toggle && pwd) {
                toggle.addEventListener('click', function () {
                    const isPwd = pwd.type === 'password';
                    pwd.type = isPwd ? 'text' : 'password';
                    this.querySelector('i').className = isPwd ? 'bx bx-show' : 'bx bx-hide';
                });
            }
        });
    </script>
</body>

</html>
