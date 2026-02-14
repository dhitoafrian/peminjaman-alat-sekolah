<x-guest-layout>
    <div class="container-fluid p-0 overflow-hidden">
        <div class="row g-0">

            <div class="col-lg-6 d-none d-lg-block">
                <div class="login-image">
                    <div class="login-overlay text-white" style="background: rgba(45, 10, 80, 0.7);">
                        <h1 class="fw-bold display-4 mb-3">Buat Akun Baru</h1>
                        <p class="lead opacity-75">Bergabung sekarang untuk mulai meminjam alat dan mengakses fitur lainnya.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center bg-white" style="min-height: 100vh;">
                <div class="w-100 p-5" style="max-width: 500px;">

                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-dark">Daftar Akun</h2>
                        <p class="text-muted">Isi data diri Anda dengan lengkap.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-lg bg-light border-0"
                                   value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0"
                                   value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light border-0" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg bg-light border-0" required>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 shadow-sm">
                                DAFTAR SEKARANG
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted small">Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">Masuk Disini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
