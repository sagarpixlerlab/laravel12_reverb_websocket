<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


// ws://192.168.1.20:8081/app/<REVERB_APP_KEY> after connect get socket id and hit below api with socket_id 
    // {
    //     "socket_id": "798641103.949251193",
    //     "channel_name": "user.1"
    // }
       // after you get the token use this token in Socket again to varify current socket user

//  Not Hit this event to connect current user with current socket 
//  {
//     "event": "pusher:subscribe",
//     "data": {
//         "auth": "your_app_key:cc8ab0d75a49133e8faca7c135547fda531768d23ba032552eb5bccde3ce7cb5",
//         "channel": "user.1"
//     }
// }

// NOTE : change websocket url & Port   -- in config/reverb.php

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/broadcasting/auth', function (Request $request) {

        if (!$request->user()) {
            return response()->json(
                [
                    'status' => false,
                    'data' => null,
                    'message' => 'Unauthorized'
                ], 401
            );
        }
        return Broadcast::auth($request);
    });

    Route::get('profile', [AuthController::class, 'profile']);
});