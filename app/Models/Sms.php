<?php
namespace App\Models;

use Webrium\Http;


class Sms
{
  public static function sendConfrimMessage($mobile){
    return Http::post('https://raygansms.com/AutoSendCode.ashx',[
      'UserName'=> 'benyaminpm',
      'Password'=> '10203040',
      'Mobile'=> $mobile,
      'Footer'=> "Kamman",
    ]);

  }


  public static function configmCode($mobile, $code){
    return Http::post('https://raygansms.com/CheckSendCode.ashx', [
      'UserName'=>'benyaminpm',
      'Password'=>'10203040',
      'Mobile'=>$mobile,
      'Code'=>$code,
    ]);
  }
}
