<x-guest-layout>
    <div class="container-fluid p-0 overflow-hidden">
        <div class="row g-0">

            <div class="col-lg-6 d-none d-lg-block">
                <div class="login-image">
                    <div class="login-overlay text-white">
                        <h1 class="fw-bold display-4 mb-3">Sistem Inventaris</h1>
                        <p class="lead opacity-75">Kelola peminjaman alat praktikum sekolah dengan mudah, cepat, dan terdata secara digital.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center bg-white" style="min-height: 100vh;">
                <div class="w-100 p-5" style="max-width: 500px;">

                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-dark">Selamat Datang</h2>
                        <p class="text-muted">Silahkan login untuk masuk ke aplikasi.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4 border-0 shadow-sm">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0"
                                   value="{{ old('email') }}" placeholder="nama@gmail.com" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light border-0"
                                   placeholder="••••••••" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label text-muted small" for="remember_me">Ingat Saya</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none small fw-bold text-primary">Lupa Password?</a>
                            @endif
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 shadow-sm">
                                MASUK SEKARANG
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted small">Belum punya akun?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Daftar Disini</a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
