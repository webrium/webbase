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
    $table->string('content', 190)->utf8mb4();
    $table->string('path', 50)->nullable();
    $table->text('description')->utf8mb4()->nullable();
    $table->string('type', 50)->default('image');
    $table->boolean('active')->default(1);
    $table->timestamps();
    $table->create();
  }



}
