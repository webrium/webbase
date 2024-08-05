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
            
            
            Route::post('update', 'Admin/AdminController->updateAdmin');


            /*
            | Category Routes
            */
            Route::post('category/new', 'Admin/CategoryController->saveNew');
            Route::post('category/update', 'Admin/CategoryController->update');
            Route::post('category/remove', 'Admin/CategoryController->remove');
        }
    );
    

    Route::group(
        [
            'prefix' => 'admin',
            'middleware' => [
                'checkAdminAuth',
                'roleAdmin'
                ]
            ],
            function () {
                Route::post('new', 'Admin/AdminController->createNewAdmin');
            }
        );


    Route::group(
        [
            'prefix' => 'admin',
            'middleware' => [
                'checkAdminAuth',
                'roleAdmin',
                'adminOtherThanMyself'
                ]
            ],
            function () {
                Route::post('remove', 'Admin/AdminController->remove');
            }
        );
        