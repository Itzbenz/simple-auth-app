<?php

use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

try{
    $table = DB::select('SHOW TABLES');
    if(count($table) == 0){
        Artisan::call('migrate:install');
    }
}catch (\Exception $e){

}

Route::get('login',array('as'=>'login',function(){
    return view('auth.login');
}));
Route::get('register', array('as'=>'register',function(){
    return view('auth.registration');
}));

Route::get('dashboard', function () {
    return view('dashboard');
});
Route::get("/", function () {
    return redirect('dashboard');
});

//sike

