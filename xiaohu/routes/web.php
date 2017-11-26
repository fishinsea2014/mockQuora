<?php

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
function user_ins()
{
    $user = new App\User;
    return $user;
}
Route::get('/', function () {
    return view('welcome');
});
Route::any('api',function (){
    return ['version'=>0.1] ;
});

Route::any('api/signUp',function (){
    /**
     * @return \App\User
     */
    return user_ins()->signUp() ;
});

Route::any('api/login',function (){
    return user_ins()->login();
});

Route::any('api/logout',function (){
    return user_ins()->log_out();

});

