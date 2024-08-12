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

        Route::post('check-auth', 'Admin/AuthController->checkAuth');
    
        Route::post('get-current', 'Admin/AuthController->currentAdmin');


        Route::post('update', 'Admin/AdminController->updateAdmin');


        /*
        | Category Routes
        */
        Route::post('category/new', 'Admin/CategoryController->saveNew');
        Route::post('category/update', 'Admin/CategoryController->update');
        Route::post('category/remove', 'Admin/CategoryController->remove');


        /*
        | Product Routes
        */

        Route::post('product/save', 'Admin/ProductController->save');
        Route::post('product/remove', 'Admin/ProductController->remove');



        /*
        | Product Content Routes
        */

        Route::post('product-content/save', 'Admin/ProductController->saveProductContent');
        Route::post('product-content/remove', 'Admin/ProductController->removeProductContent');



        /*
        | Product Category Routes
        */
        Route::post('product-category/save', 'Admin/ProductController->saveProductCategory');
        Route::post('product-category/remove', 'Admin/ProductController->removeProductCategory');
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
