<?php
use Webrium\Route;

// with auth
Route::group(
    [
        'prefix' => 'user',
        'middleware' => [
            'checkUserAuth'
        ]
    ],
    function () {
        Route::post('is-login', 'User/UserController->checkLogin');
        Route::post('add-to-card', 'User/CardController->addToCard');
    }
);