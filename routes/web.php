<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MovementController;


// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

Route::get('/academico', function () {
    return view('pages.academico.index');
})->name('academico');

Route::get('/admisiones', function () {
    return view('pages.admisiones.index');
})->name('admisiones');

Route::get('/nosotros', function () {
    return view('pages.nosotros.index');
})->name('nosotros'); // Asegúrate de tener esta vista

Route::get('/contactanos', function () {
    return view('pages.contacto.contacto');
})->name('contactanos');


// Autenticación (desactivé el registro como sugerí antes)
Auth::routes(['register' => false]);

// Rutas protegidas (requieren login)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Inventario - CRUD
    Route::resource('references', ReferenceController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    
    // Movimientos
    Route::prefix('movements')->group(function () {
        Route::get('/', [MovementController::class, 'index'])->name('movements.index');
        Route::get('/filter', [MovementController::class, 'filter'])->name('movements.filter');
        Route::post('/{movement}/reverse', [MovementController::class, 'reverse'])->name('movements.reverse');
    });
    
    // Acciones especiales
    Route::post('/products/{product}/register-movement', [ProductController::class, 'registerMovement'])
        ->name('products.register-movement');

        
});