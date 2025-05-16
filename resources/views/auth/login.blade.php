<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <!-- Optional: Dark mode toggle CSS -->
    <style>
        body {
            background-color: #121212;
            color: #f1f1f1;
        }
        .card {
            background-color: #1e1e1e;
            border: none;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .form-check-label {
            color: #f1f1f1;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-danger {
            background-color: #db4437;
            border-color: #db4437;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-2 mt-4 float-end mx-3 not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a
                        href="{{ url('admin/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div class="min-h-screen bg-gray-900">
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 75vh;">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center py-3 rounded-top">
                        <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</h4>
                    </div>

                    <div class="card-body px-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Your Email">
                                @error('email')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Remember Me and Forgot Password -->
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none text-primary" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">
                                <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                            </button>

                            <!-- Or Section -->
                            <div class="text-center my-3">
                                <small class="text-muted">or</small>
                            </div>

                            <!-- Google Login Button -->
                            <a href="{{ route('auth.google') }}" class="btn btn-danger w-100 py-2 rounded-pill">
                                <i class="fab fa-google"></i> {{ __('Login with Google') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
