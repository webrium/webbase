<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class ProductType extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'product_types';

  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->string('title');
    $table->string('label');
    $table->timestamps();
    $table->create();
  }



}
