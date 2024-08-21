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
        Route::post('category/save', 'Admin/CategoryController->saveNew');
        Route::post('categorys', 'Admin/CategoryController->getList');
        Route::post('category/remove', 'Admin/CategoryController->remove');


        /*
        | Product Routes
        */

        Route::post('product/save', 'Admin/ProductController->save');
        Route::post('product/remove', 'Admin/ProductController->remove');
        Route::post('product/info', 'Admin/ProductController->getProductInfo');



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
-

        /*
        | Product Type Routes
        */
        Route::post('product-type/save', 'Admin/ProductController->saveProductType');
        Route::post('product-type/remove', 'Admin/ProductController->removeProductType');

        Route::post('product-types', 'Admin/ProductController->productTypes');
        Route::post('product-categorys', 'Admin/ProductController->productCategorys');


        // save new file
        Route::post('file/save', 'Admin/FileController->saveFile');
        // Route::
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
