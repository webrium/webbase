<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;
use Webrium\Header;
use Webrium\Http;
use Webrium\Jwt;

class User extends Model{

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'users';


  public static $user = false;


  public function createTable(){
    $table = new Schema($this->table);
    $table->id();
    $table->string('mobile', 50);
    $table->string('email', 150)->nullable();
    $table->integer('mobile_confirm', 6)->default(0);
    $table->string('name');
    $table->string('code')->nullable();
    $table->string('image')->nullable();
    $table->dateTime('birth_date')->nullable();
    $table->string('postal_code')->nullable();
    $table->string('city')->nullable();
    $table->text('address')->nullable();
    $table->string('password');
    $table->string('token', 100);
    $table->timestamps();
    $table->create();

  }

  protected static function makeJwtSecretKey($user, $ip){
    return $user->token."_$ip";
  }

  public static function getAuthToken($user){
    

      $ip = Http::ip();

      $secretKey = self::makeJwtSecretKey($user, $ip);
      
      $jwt = new Jwt($secretKey);
      $auth_token = $jwt->generateToken(['id'=>$user->id]);



      return $auth_token;
    
  }


  public static function checkAuth(){

    $jwt_token = trim(Header::getBearerToken());

    $payload = Jwt::getPayload($jwt_token);

    if(isset($payload->id)){
      
      $admin_id = $payload->id;
      
      $user = User::find($admin_id);
      
      if($user){
        $jwt = new Jwt(self::makeJwtSecretKey($user, Http::ip()));
        self::$user = $user;
        return $jwt->verifyToken($jwt_token)?true:false;
      }

    }

    return false;
  }
}
