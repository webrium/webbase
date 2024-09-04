<?php
namespace App\Controllers\User;

use App\Models\Captcha;
use App\Models\Category;
use App\Models\Product;
use App\Models\File;
use App\Models\ProductCategory;
use App\Models\ProductContent;
use App\Models\ProductInventory;
use App\Models\ProductType;
use App\Models\Sms;
use Webrium\FormValidation;
use Webrium\Hash;
use App\Models\User;
use Webrium\Http;

class UserController
{


    public function register(){

        $form = new FormValidation();

        $form->field('name', 'نام و نام خانوادگی')->required()->min(3);
        $form->field('mobile', 'شماره همراه')->required()->min(10)->max(11);
        $form->field('code', 'کد ملی')->required()->min(10)->max(10);
        $form->field('password', 'رمزعبور')->required()->confirmed('confirm_password')->min(6);
    

        $name = input('name');
        $code = input('code');
        $mobile = input('mobile');
        $password = input('password');
        $captcha = input('captcha');
 

        if($form->isValid() == false){
            return['ok'=>false, 'message'=>$form->getFirstErrorMessage()];
        }

        if(User::where('code', $code)->exists()){
            return['ok'=>false, 'message'=>'این کد ملی قبلا ثبت شده است'];
        }

        if(User::where('mobile', $mobile)->exists()){
            return['ok'=>false, 'message'=>'این شماره همراه قبلا استفاده شده است'];
        }

        $captcha_result = Captcha::confirm($captcha, Http::ip());

        if ($captcha_result['ok'] == false) {
            return $captcha_result;
        }


        $user = new User;

        $user->name = $name;
        $user->code = $code;
        $user->mobile = $mobile;
        $user->password = Hash::make($password);
        $user->token = bin2hex(random_bytes(32));
        $user->save();

        Sms::sendConfrimMessage('09193681670');

        return ['ok'=>true, 'user_id'=>$user->id];
    }


    public function confirmMobileCode(){

        $code = trim(input('code', ''));
        $mobile = trim(input('mobile', ''));

        $result = Sms::configmCode($mobile, $code);

        $login = false;
        $auth_token = '';

        if($result ==='true'){
            $user = User::where('mobile', $mobile)->find();

            if($user){
                $user->mobile_confirm = 1;
                $user->save();
                $login = true;
                $auth_token = User::getAuthToken($user);
            }
            else{
                return['ok'=>false, 'message'=>'شماره و حساب کاربری یافت نشد'];
            }
        }

        return['ok'=>true, 'result'=>$result, 'login'=>$login, 'auth_token'=>$auth_token];
    }


    public function login(){
        $mobile = input('mobile');
        $password = input('password');
        $captcha = input('captcha');


        $captcha_result = Captcha::confirm($captcha, Http::ip());

        if ($captcha_result['ok'] == false) {
            return $captcha_result;
        }


        $user = User::select('id', 'name', 'mobile','mobile_confirm', 'password', 'token')->where('mobile', $mobile)->first();

        if($user && $user->mobile_confirm == 0){
            return['ok'=>false, 'confrim'=>false];
        }

        if($user && Hash::check($password, $user->password)){
            $auth_token = User::getAuthToken($user);
            unset($user->password);
            unset($user->token);
            return ['ok'=>true,'user'=>$user, 'login'=>true, 'auth_token'=>$auth_token];
        }

        return['ok'=>false, 'message'=>'شماره همراه یا رمزعبور وارد شده اشتباه است'];
    }


    public function checkLogin(){
        return['ok'=>true];
    }

}