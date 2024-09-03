<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\LandImageController;
use App\Http\Controllers\LandVideoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FavoriteLandController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Routes pour les utilisateurs (vendeurs)
Route::group(['prefix' => 'users','middleware' => ['auth:sanctum', 'is_admin']], function() {
    Route::get('/', [UserController::class, 'index'])->name('users.index'); // Liste des utilisateurs
    Route::post('/', [UserController::class, 'store'])->name('users.store'); // Créer un utilisateur
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show'); // Afficher un utilisateur spécifique
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update'); // Mettre à jour un utilisateur
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Supprimer un utilisateur
    });


Route::group(['prefix' => 'users','middleware' => ['auth:sanctum', 'is_admin']], function() {
    Route::post('/adminAddUser' ,[UserController::class, 'storeAdmin'])->name('users.adminAdd');    
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('loginphone','loginWithPhone');
});

// Routes pour les terrains (propriétés)
Route::group(['prefix' => 'Land','middleware' => ['auth:sanctum']], function() {
    Route::get('/', [LandController::class, 'index'])->name('Land.index'); // Liste des terrains
    Route::post('/', [LandController::class, 'store'])->name('Land.store'); // Ajouter un terrain
    Route::get('/{id}', [LandController::class, 'show'])->name('Land.show'); // Afficher un terrain spécifique
    Route::put('/{id}', [LandController::class, 'update'])->name('Land.update'); // Mettre à jour un terrain
    Route::delete('/{id}', [LandController::class, 'destroy'])->name('Land.destroy'); // Supprimer un terrain
    Route::get('/show/myland', [LandController::class, 'showMyLand'])->name('Land.showMyLand'); // afficher mes  terrain
});
Route::group(['prefix'=>'landImage',`middleware` => ['auth:sanctum']], function(){
    Route::get('/{id}', [LandImageController::class,'show'])->name('landImage.show'); // Afficher une image de terrain spécifique
    Route::post('/', [LandImageController::class,'store'])->name('landImage.store'); // Ajouter une image de terrain
    Route::put('/{id}', [LandImageController::class,'update'])->name('landImage.update'); // Mettre à jour une image de terrain
    Route::delete('/{id}', [LandImageController::class,'destroy'])->name('landImage.destroy'); // Supprimer une image de terrain
    Route::get('/', [LandImageController::class,'index'])->name('landImage.index'); // Liste des images de terrain
    });
Route::group(['prefix'=>'landVideo','middleware' => ['auth:sanctum']], function(){
    Route::get('/{id}', [LandVideoController::class,'show'])->name('landVideo.show'); // Afficher une vidéo de terrain spécifique
    Route::post('/', [LandVideoController::class,'store'])->name('landVideo.store'); // Ajouter une vidéo de terrain
    Route::put('/{id}', [LandVideoController::class,'update'])->name('landVideo.update');
    Route::delete('/{id}', [LandVideoController::class,'destroy'])->name('landVideo.destroy'); // Supprimer une vidéo de terrain
    Route::get('/', [LandVideoController::class,'index'])->name('landVideo.index'); // Liste des vidéos de terrain
});

// Routes pour les administrateurs (nécessite des autorisations supplémentaires)
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'is_admin']], function() {
    Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users.index'); // Liste des utilisateurs pour les admins
    Route::get('/terrains', [AdminController::class, 'listTerrains'])->name('admin.terrains.index'); // Liste des terrains pour les admins
    Route::put('/approve-terrain/{id}', [AdminController::class, 'approveTerrain'])->name('admin.terrains.approve'); // Approuver un terrain
    Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete'); // Supprimer un utilisateur
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/lands/favorite', [FavoriteLandController::class, 'store']);
    Route::delete('/lands/favorite/{id}', [FavoriteLandController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/messages', [MessageController::class, 'send']);
    Route::get('/messages', [MessageController::class, 'index']);
});

// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/conversations/user', [MessageController::class, 'getUserConversations']);
    Route::get('/conversations/admin', [MessageController::class, 'getAdminConversations']);
});





// Route pour récupérer l'utilisateur authentifié
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});