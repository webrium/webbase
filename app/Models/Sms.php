<?php
namespace App\Models;

use Webrium\Http;


class Sms
{
  public static function sendConfrimMessage($mobile){
    return Http::post('https://raygansms.com/AutoSendCode.ashx',[
      'UserName'=> env('SMS_USERNAME'),
      'Password'=> env('SMS_PASSWORD'),
      'Mobile'=> $mobile,
      'Footer'=> "Kamman",
    ]);

  }


  public static function configmCode($mobile, $code){
    return Http::post('https://raygansms.com/CheckSendCode.ashx', [
      'UserName'=>env('SMS_USERNAME'),
      'Password'=>env('SMS_PASSWORD'),
      'Mobile'=>$mobile,
      'Code'=>$code,
    ]);
  }
}
