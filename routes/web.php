    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\Admin\AlatController;
    use App\Http\Controllers\PeminjamanController;
    use App\Http\Controllers\Admin\AdminPeminjamanController;


    // Redirect root berdasarkan auth status
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    });

    Route::middleware('auth')->group(function () {

        // Dashboard untuk semua user (admin/user)
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Routes untuk ADMIN saja
        Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
            // Manajemen Alat
            Route::resource('alat', AlatController::class);;

            // Manajemen Peminjaman (Admin)
            Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
                Route::get('/', [AdminPeminjamanController::class, 'index'])->name('index');
                Route::patch('/{peminjaman}/approve', [AdminPeminjamanController::class, 'approve'])->name('approve');
                Route::patch('/{peminjaman}/reject', [AdminPeminjamanController::class, 'reject'])->name('reject');
                Route::patch('/{peminjaman}/return', [AdminPeminjamanController::class, 'return'])->name('return');
            });
        });

        // Routes untuk USER biasa
        Route::middleware('auth')->group(function () {
            // Pinjam alat (dari katalog)
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // Khusus User
            Route::middleware(['role:user'])->group(function () {
                Route::get('/peminjaman/create/{alat}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
                Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
                Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
            });
        });
    });

    require __DIR__ . '/auth.php';
