<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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


Route::post("/get_list", function (Request $request) {



   return response(array("message" => 'success', "user_object" => $request->all()), 200);

});

Route::get("/get_list", function (Request $request) {




    return response()->json(["data" => $request->all()]);

    //return response(array("message" => 'success', "user_object" => $request->all()), 200);

});

