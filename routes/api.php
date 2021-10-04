<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* 
    Remember than routes declared in api.php will automatically concat to /api prefix, btw:
    Eg: 
       http://localhost/laravel8/laravel8pro/public/api/users/raja
 */

Route::group(['middleware' => ['api', 'auth:api', 'prevent-back-history'],], function () {
    Route::post('/oneuser', [UserController::class, 'getUser'],)->name('apioneuser');
    Route::post('/allusers', [UserController::class, 'getAllUsersDataTable'],)->name('apiallusers');
    Route::post('/updateuser', [UserController::class, 'updateUser'],)->name('apiupdateuser');
    Route::post('/adnewuser', [UserController::class, 'adnewUser'],)->name('apiadnewuser');
    Route::post('/changeuserstatus', [UserController::class, 'changeUserStatus'],)->name('apichangeuserstatus');
    Route::post('/deleteuser', [UserController::class, 'deleteUser'],)->name('apideleteuser');
    Route::post('/userpasswordreset', [UserController::class, 'userPasswordReset'],)->name('apiuserpasswordreset');
});
