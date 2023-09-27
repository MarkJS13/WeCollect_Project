<?php

use App\Http\Controllers\Admin\TransactionCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::group([
//     'middleware' => 'api',
//     'namespace'  => 'App\Http\Controllers\Admin',
// ], function () { // custom admin routes
//     Route::prefix('transactions')->group(function () {
//         Route::get('/', 'TransactionCrudController@setupListOperation');
//         // Route::post('/', 'TransactionCrudController@setUpCreateOperation');
//         // Route::put('/{id}', 'TransactionCrudController@setupUpdateOperation');
//         // Route::delete('/{id}', 'TransactionCrudController@setupDeleteOperation');
//     });
// }); // this should be the absolute last line of this file

