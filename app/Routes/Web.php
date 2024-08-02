<?php
use Webrium\Route;

Route::setNotFoundRoutePage(function(){
    return ['ok'=>false, 'error'=>404, 'message'=>'Page not found'];
});

Route::get('','IndexController->index');
Route::post('captcha/check-ability','CaptchaController->checkingTheAbilityToCreateCaptcha');
Route::get('captcha/show','CaptchaController->showNew');

