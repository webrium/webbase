<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class View extends Model{

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'views';

  public function createTable(){
    $table = new Schema($this->table);
    $table->id();
    $table->string('type', 50);
    $table->integer('external_id');
    $table->string('ip',50);
    $table->integer('count')->default(1);
    $table->timestamps();
    $table->create();
  }


}
