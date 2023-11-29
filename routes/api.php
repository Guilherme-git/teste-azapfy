<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\NotaFiscalController;

Route::controller(UsuarioController::class)->group(function (){
    Route::prefix("usuario")->group(function () {
        Route::post("login","login");
        Route::post("create","create");
    });
});

Route::group(['middleware'=>['jwtRoute']],function (){
    Route::controller(NotaFiscalController::class)->group(function (){
        Route::prefix("nota-fiscal")->group(function () {
            Route::post("create","create");
            Route::get("list-by-user","listByUser");
            Route::get("view","view");
            Route::put("update","update");
            Route::delete("delete","delete");
        });
    });
});



