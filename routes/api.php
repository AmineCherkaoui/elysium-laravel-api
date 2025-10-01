<?php



use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;





Route::prefix('auth')->group(function () {
    // Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login');

    Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'user']);
    Route::put('me/update', [AuthController::class,'updateUser']);
    });
});


Route::prefix('contacts')->group(function () {
    Route::post('/', [ContactController::class, 'store'])->middleware('throttle:contact');

    Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', [ContactController::class, 'index']);
    Route::get('/{id}', [ContactController::class, 'show']);
    Route::delete('/{id}', [ContactController::class, 'destroy']);
    Route::patch('/{contact}/read', [ContactController::class, 'markAsRead']);
});

});


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{slug}', [ProductController::class, 'showBySlug']);

    Route::middleware('auth:sanctum')->group(function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{slug}', [ProductController::class, 'update']);
    Route::delete('/{slug}', [ProductController::class, 'destroy']);
});

});


Route::prefix('commandes')->group(function () {
    Route::post('/', [CommandeController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [CommandeController::class, 'index']);
        Route::get('/{numero}', [CommandeController::class, 'show']);
        Route::patch('/{numero}/status', [CommandeController::class, 'updateStatus']);
        Route::delete('/{numero}', [CommandeController::class, 'destroy']);
    });

});

Route::prefix("dashboard")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [DashboardController::class,"summary"]);
});






