<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class ProductContent extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'product_contents';

  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->integer('product_id');
    $table->string('type', 50)->utf8()->default('image');
    $table->string('content', 190)->utf8mb4();
    $table->string('path')->utf8()->nullable();
    $table->text('json')->utf8()->nullable();
    $table->boolean('active')->default(1);
    $table->timestamps();
    $table->create();
  }



}
