<?php
use Webrium\Route;

Route::setNotFoundRoutePage(function(){
    return ['ok'=>false, 'error'=>404, 'message'=>'Page not found'];
});

Route::get('','IndexController->index');

Route::group('captcha', function(){
    Route::post('check-ability','CaptchaController->checkingTheAbilityToCreateCaptcha');
    Route::get('show','CaptchaController->showNew');
});


Route::group('product', function(){
    Route::get('info', 'User/ProductController->productInfo');
});

