<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;
use webrium\Http;

class View extends Model{

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'views';

  public function createTable(){
    $table = new Schema($this->table);
    $table->id();
    $table->string('type', 50);
    $table->integer('external_id');
    $table->string('ip',50);
    $table->integer('count')->default(1);
    $table->timestamps();
    $table->create();
  }


  public function new($type, $external_id){
    $ip = Http::ip();

    $view = View::where('external_id', $external_id)->and('ip', $ip)->and('type', $type)->find();

    if($view==false){
      $view = new View;
      $view->external_id = $external_id;
      $view->ip = $ip;
      $view->type = $type;
    }
    else{
      $view->count += 1;
    }
    
    $view->save();

    return $view;
  }

}
