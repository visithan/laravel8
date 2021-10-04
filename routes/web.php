<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/* Route::get('/users/{id?}', function ($id = null) {             //Parameter is optional(? and = null)
    return "Hi User $id";    
})->where('id','[a-zA-Z0-9]+'); */



// Route::get('/login', [LoginController::class, 'login'])->name('login');

/*Route::middleware(['auth:api'])->group(function () {
    Route::get('/', function () {
        // Uses first & second middleware...
    });

    Route::get('user/profile', function () {
        // Uses first & second middleware...
    });
});*/

Route::match(['get', 'post'], '/', [LoginController::class, 'login'])
    ->name('login')
    ->middleware('check_logedin');
Route::match(['get', 'post'], '/register', [LoginController::class, 'register'])
    ->name('register')
    ->middleware('check_logedin');


Route::group(['middleware' => ['auth', 'prevent-back-history'],], function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'], function () {
        // Only authenticated users may enter...
    })->name('dashboard');

    Route::get('/logout', [LoginController::class, 'logout'], function () {
        // Only authenticated users may enter...
    })->name('logout');

    Route::get('/user', [UserController::class, 'getAllUsers'], function () {
        // Only authenticated users may enter...
    })->name('user');

    Route::match(['get', 'post'], '/oneuser', [UserController::class, 'getUser'],)->name('oneuser');

    Route::post('/allusers', [UserController::class, 'getAllUsersDataTable'], function () {
        // Only authenticated users may enter...
    })->name('allusers');

    Route::post('/updateuser', [UserController::class, 'updateUser'], function () {
        // Only authenticated users may enter...
    })->name('updateuser');

    Route::post('/adnewuser', [UserController::class, 'adnewUser'],)->name('adnewuser');
    Route::post('/changeuserstatus', [UserController::class, 'changeUserStatus'],)->name('changeuserstatus');
    Route::post('/deleteuser', [UserController::class, 'deleteUser'],)->name('deleteuser');
    Route::post('/userpasswordreset', [UserController::class, 'userPasswordReset'],)->name('userpasswordreset');
});


//Route::post('myform/update/{id}', 'UserController@update');
// Update user
// class UserController extends Controller{
//     public function update(Request $request, $id){
//      $user= myform::findOrFail($id);
//     }
// }
