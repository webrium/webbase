<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class Product extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'products';

  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->string('title', 150)->utf8mb4();
    $table->string('url', 190)->utf8mb4();
    $table->string('code', 50)->nullable();
    $table->text('description')->utf8mb4()->nullable();
    $table->text('attributes')->utf8()->nullable();
    $table->integer('price');
    $table->integer('show_price')->default(0);
    $table->string('image')->nullable();
    $table->integer('ages', 3);
    $table->integer('producer_id')->nullable();
    $table->timestamps();
    $table->create();

    $table->addColumn()->boolean('active')->after('producer_id')->change();
  }

  public static function new($params)
  {
    return self::insert($params);
  }


  public function updateProduct($id, $params)
  {
    return self::where('id', $id)->update($params);
  }

  public function remove($id)
  {
    self::where('id', $id)->delete();
  }





}
