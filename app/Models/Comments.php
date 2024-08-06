<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class Comments extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'comments';

  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->integer('user_id');
    $table->text('comment');
    $table->integer('product_id');
    $table->boolean('confirm')->default(0);
    $table->timestamps();
    $table->create();
  }



}
