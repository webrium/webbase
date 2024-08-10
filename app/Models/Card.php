<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class Card extends Model{

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'cards';

  public function createTable(){
    $table = new Schema($this->table);
    $table->integer('user_id');
    $table->integer('product_id');
    $table->timestamps();
    $table->create();
  }


}
