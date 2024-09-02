<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class ProductInventory extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'product_inventories';

  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->integer('product_id');
    $table->string('title');
    $table->string('type', 50)->nullable();
    $table->string('type_value')->nullable();
    $table->integer('amount')->default(0);
    $table->integer('price')->nullable();
    $table->integer('show_price');
    $table->text('images')->nullable()->utf8();
    $table->timestamps();
    $table->create();
  }



}
