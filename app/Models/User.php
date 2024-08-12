<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class User extends Model{

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'users';


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
    $table->timestamps();
    $table->create();

  }


}
