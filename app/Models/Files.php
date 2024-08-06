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
  protected $table = 'files';

  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->string('name');
    $table->string('path');
    $table->string('type',20);
    $table->timestamps();
    $table->create();
  }



}
