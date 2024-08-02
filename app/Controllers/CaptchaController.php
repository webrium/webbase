<?php
namespace App\Controllers;
use App\Models\Captcha;

class CaptchaController
{

  public function showNew()
  {
    return Captcha::showNew();
  }


  public function checkingTheAbilityToCreateCaptcha(){
    return Captcha::showNew(true);
  }


}
