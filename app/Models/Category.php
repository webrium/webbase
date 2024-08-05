<?php
namespace App\Models;

use Foxdb\Model;

use Foxdb\Schema;
use Webrium\FormValidation;

class Category extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'categorys';


  public function createTable()
  {
    $table = new Schema($this->table);
    $table->id();
    $table->string('title', 140)->utf8();
    $table->string('url', 190)->utf8();
    $table->integer('link_to')->default(0);
    $table->boolean('active')->default(1);
    $table->timestamps();
    $table->create();
  }

  public static function new($title, $link_to = 0)
  {

    $category = Category::where('title', $title)->find();

    if ($category) {
      return ['ok' => false, 'message' => lang('message.information_already_exists')];
    }

    $category = new Category;

    $category->title = $title;
    $category->url = str_replace(' ', '-', $title);
    $category->link_to = $link_to;
    $category->save();

    return ['ok' => true];
  }


  public static function updateCategory($title, $change)
  {


    $category = Category::where('title', $title)->find();

    if($category){
      $category->title = $change;
      $category->url = str_replace(' ', '-', $change);
      $category->save();

      return ['ok'=>true];
    }
    else{
      return['ok'=>false, 'message'=>lang('message.information_not_found')];
    }

  }


  public static function removeCategory($id){

    return['ok'=>Category::where('id' ,$id)->delete()];
  }


}
