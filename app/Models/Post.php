<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;

class Post extends Model{

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'posts';

  public function createTable(){
    $table = new Schema($this->table);
    $table->id();
    $table->string('title', 140)->utf8mb4();
    $table->string('url', 190)->utf8mb4();
    $table->text('content');
    $table->text('excerpt');
    $table->integer('author_id')->default(0)->nullable();
    $table->string('status', 30)->default(1);
    $table->boolean('comment_status');
    $table->smallInt('menu_order');
    $table->timestamps();
    $table->create();
  }


}
