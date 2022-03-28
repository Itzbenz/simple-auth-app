<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    if(Auth::attempt($credentials)){
        $request->session()->regenerate();
        return response()->json(['success' => true]);
    }else{
        return response()->json(['success' => false]);
    }

});


Route::post('/register', function (Request $request) {
    $cred = $request->validate([
        'username' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'phone' => ['required', 'string', 'min:8', 'max:15'],
    ]);
    //check if user exists
    $user = User::where('email', $request->email)->first();
    if($user){
        return response()->json(['fail' => 'User already exists'], 401);
    }
    $user = new User();
    $user->username = $request->username;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->phone = $request->phone;
    $user->save();
    return response()->json(['success' => true]);
});



Route::get("/user", function (Request $request) {
    $user = auth()->user();
    if ($user) {
        return response()->json(['success' => $user], 200);
    } else {
        return response()->json(['error' => 'User not logged in'], 401);
    }
});
