<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;
use Webrium\Http;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Captcha extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'captchas';



  public function createTable()
  {
    $table = new Schema($this->table);
    $table->bigID();
    $table->string('phrase', 100);
    $table->string('ip', 200);
    $table->time('last_created_datetime')->nullable();
    $table->boolean('confirm')->default(0);
    $table->integer('edit_number')->default(0);
    $table->timestamps();
    $table->create();
  }


  public static function permissionToCreateCaptcha($captcha)
  {
    if (time() - $captcha->last_created_datetime < 60 && $captcha->edit_number >= 5 && $captcha->confirm == false) {
      return ['ok' => false, 'message' => 'Try again in 60 seconds', 'diff' => time() - $captcha->last_created_datetime];
    }

    return ['ok' => true];
  }


  public static function showNew($just_check_ability = false)
  {
    $ip = Http::ip();


    // Will build phrases of 5 characters, only digits
    $phraseBuilder = new PhraseBuilder(5, 'tukwzxcvbmp8234');

    $builder = new CaptchaBuilder(null, $phraseBuilder);
    $builder->build();

    $phrase = $builder->getPhrase();

    $captcha = Captcha::where('ip', $ip)->find();

    if ($captcha == false) {
      $captcha = new Captcha;
      $captcha->ip = $ip;
    }


    $permission = self::permissionToCreateCaptcha($captcha);

    if ($just_check_ability) {
      return $permission;
    }

    if ($permission['ok'] == false) {
      $builder = new CaptchaBuilder('Limited');
      $builder->build();
      header('Content-type: image/jpeg');

      return $builder->output();
    }

    $captcha->phrase = strtolower($phrase);
    $captcha->last_created_datetime = time();
    $captcha->edit_number += 1;
    $captcha->confirm = false;

    $captcha->save();


    header('Content-type: image/jpeg');
    $builder->output();
  }


  public static function confirm($phrase, $ip)
  {
    $captcha = Captcha::where('ip', $ip)->false('confirm')->find();

    if ($captcha && $captcha->phrase === strtolower($phrase)) {

      if (time() - $captcha->last_created_datetime > 60 * 4) {
        return ['ok' => false, 'message' => 'Captcha code has expired', 'reload_captcha' => true];
      }

      $captcha->confirm = true;
      $captcha->edit_number = 0;
      $captcha->save();

      return ['ok' => true, 'captcha' => $captcha];
    }

    return ['ok' => false, 'message' => 'Captcha code is not correct', 'reload_captcha' => false];
  }


}
