<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
//used by login and registration
function login(Request  $request){
    try {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => $e->errors(),
        ], 401);
    }
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json([
            'message' => 'User not found',
        ], 401);
    }
    //user found, check password
    if (!Hash::check($request->password, $user->password)) {// redundant going to get checked again
        return response()->json([
            'message' => 'Password is incorrect',
        ], 401);
    }
    $token = Str::random(60);
    $user->token = $token;//invalidate other tokens
    $user->save();
    //try check again
    if(!Auth::attempt($credentials)){
        //how
        return response()->json([
            'message' => 'User not found',
        ], 401);
    }
    //great success
    return response([
        'message' => 'Login successful',
        'token' => $token,//please save it
        'redirect' => '/',
    ], 200);

}

//yes
Route::post('login', function (Request $request) {
    return login($request);
});

//mmmmm
Route::post('register', function (Request $request) {
    try {
        $cred = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],//at least 1 uppercase, lowercase, greek letter, cyrillic, number, special character
            'phone' => ['required', 'string', 'min:8', 'max:15'],
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => $e->errors(),//terrible
        ], 401);
    }
    //check if user exists
    $user = User::where('email', $request->email)->first();
    if($user){
        return response([
            'message' => 'User already exists'
        ], 400);//what
    }
    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'token' => Str::random(60),//good
    ]);
    return login($request);
});



Route::get("user", function (Request $request) {
    //middleware is overrated
    $token = $request->header('Authorization');
    if(!$token){
        return response([
            'message' => 'Token invalid'
        ], 401);
    }
    //query the database
    $user = User::where('token', $token)->first();
    if ($user) {
        //found
        return response([
            'data' => $user
        ]);
    } else {
        //not found
        return response([
            'message' => 'Token invalid'
        ], 401);
    }
});

Route::put("user", function (Request $request) {
    $token = $request->header('Authorization');
    if(!$token){
        //what
        return response([
            'message' => 'Token invalid'
        ], 401);
    }
    //query user
    $user = User::where('token', $token)->first();
    if ($user) {
        //validate request
        try {
             $request->validate([
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone' => ['required', 'string', 'min:8', 'max:15'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => $e->errors(),
            ], 401);
        }
        $user->update($request->all());
        return response([
            'data' => $user
        ]);
    } else {
        return response([
            'message' => 'Token invalid'
        ], 401);
    }
});
