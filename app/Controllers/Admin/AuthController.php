<?php
namespace App\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Captcha;
use Webrium\Http;
use Webrium\FormValidation;

class AuthController
{

    public function ping()
    {
        return ['ok' => true, 'online' => true, 'date' => date('Y-m-d H:i:s')];
    }




    public function auth()
    {
        $username = input('username');
        $password = input('password');
        $captcha = input('captcha', '');

        $form = new FormValidation();

        $form
            ->field('username')->required()->min(3)
            ->field('password')->required()->min(6)
            ->field('captcha')->required();

        if ($form->isValid() == false) {
            return ['ok'=>false, 'message'=>$form->getFirstErrorMessage()];
        }

        $captcha_result = Captcha::confirm($captcha, Http::ip());

        if ($captcha_result['ok']) {

            return Admin::getAuthToken($username, $password);

        } else {
            return $captcha_result;
        }
    }

    public function checkAuth()
    {
        return Admin::checkAuth();
    }





}