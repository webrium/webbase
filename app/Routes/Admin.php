<?php
use Webrium\Route;


// without auth
Route::group(
    'admin',
    function () {

        Route::post('auth', 'Admin/AuthController->auth');
    }
);


// with auth
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [
            'checkAdminAuth'
            ]
        ],
        function () {
            
            // Route::post('check-auth', 'Admin/AuthController->checkAuth');
            
            Route::post('get-current', 'Admin/AuthController->currentAdmin');
            
            Route::post('new', 'Admin/AdminController->createNewAdmin');

            Route::post('update', 'Admin/AdminController->updateAdmin');
    }
);
