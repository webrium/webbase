<?php
namespace App\Models\Admin;

use Foxdb\Model;
use Foxdb\Schema;
use Webrium\Hash;
use Webrium\Jwt;
use Webrium\Http;
use Webrium\Header;


class Admin extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'admins';

  protected $visible = ['id', 'username', 'token', 'secret', 'created_at', 'updated_at'];

  private static $admin = false;


  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->string('username', 100);
    $table->string('password', 200);
    $table->string('last_login_ip', 50)->nullable();
    $table->dateTime('last_login_datetime')->nullable();
    $table->boolean('active')->default(true);
    $table->string('token', 150);
    $table->string('secret', 30)->nullable();
    $table->timestamps();
    $table->create();
  }

  /**
   * Create a new admin
   * 
   * @param mixed $username
   * @param mixed $password
   * @return Admin
   */
  public function new($username, $password)
  {
    $admin = new Admin;

    $admin->username = $username;
    $admin->password = Hash::make($password);
    $admin->token = bin2hex(random_bytes(32));
    $admin->save();

    return $admin;
  }

  public function reNewToken($admin_id)
  {
    $admin = Admin::find($admin_id);

    if ($admin) {
      $admin->token = bin2hex(random_bytes(32));
      $admin->save();
    }

    return $admin;
  }


  public function insertMainAdmin()
  {
    if (env('insert_main_admin') == 'true') {
      (new Admin)->new(env('main_admin_username'), env('main_admin_password'));
    }
  }


  public static function auth($username, $password){
    $admin = Admin::select('id', 'password')->where('username', $username)->find();

    if($admin){
      $auth = Hash::check($password, $admin->password);

      if($auth){
        return['ok'=>true, 'admin'=>$admin];
      }
    }

    return ['ok'=>false];
  }

  protected static function makeJwtSecretKey($admin, $ip){
    return $admin->token."_$admin->secret"."_$ip";
  }



  public static function getAuthToken($username, $password){
    
    $auth = self::auth($username, $password);

    if($auth['ok']){
      $admin = $auth['admin'];

      $ip = Http::ip();
      
      $admin->secret = bin2hex(random_bytes(10));
      $admin->last_login_ip = $ip;
      $admin->last_login_datetime = date('Y-m-d H:i:s');
      $admin->save();

      $secretKey = self::makeJwtSecretKey($admin, $ip);
      
      $jwt = new Jwt($secretKey);
      $auth_token = $jwt->generateToken(['id'=>$admin->id]);

      return['ok'=>true, 'auth_token'=>$auth_token];
    }

    return['ok'=>false];
  }


  public static function current(){
    return self::$admin;
  }


  public static function checkAuth(){
    $jwt_token = Header::getBearerToken();
    $payload = Jwt::getPayload($jwt_token);

    if(isset($payload->id)){

      $admin_id = $payload->id;

      $admin = Admin::find($admin_id);

      if($admin){
        $jwt = new Jwt(self::makeJwtSecretKey($admin, Http::ip()));
        self::$admin = $admin;
        return $jwt->verifyToken($jwt_token)?true:false;
      }

    }

    return false;
  }


  


}
