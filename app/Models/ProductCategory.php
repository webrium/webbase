<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class ProductCategory extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'product_categorys';

  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->integer('product_id');
    $table->integer('category_id');
    $table->integer('link_to')->default(0);    
    $table->string('title', 140);
    $table->timestamps();
    $table->create();
  }



}
