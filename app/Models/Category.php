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
    $table->integer('parent_id')->default(0);
    $table->boolean('active')->default(1);
    $table->timestamps();
    $table->create();
  }

  public static function store($id, $title, $url, $parent_id = 0)
  {

    $category = Category::where('title', $title)->find();

    if ($category) {
      return ['ok' => false, 'message' => lang('message.information_already_exists')];
    }

    if ($id == 0) {
      $category = new Category;
    } else {
      $category = Category::find($id);
    }

    $category->title = $title;
    $category->url = $url;
    $category->parent_id = $parent_id;
    $category->save();

    return ['ok' => true];
  }


  public static function updateCategory($title, $change)
  {


    $category = Category::where('title', $title)->find();

    if ($category) {
      $category->title = $change;
      $category->url = str_replace(' ', '-', $change);
      $category->save();

      return ['ok' => true];
    } else {
      return ['ok' => false, 'message' => lang('message.information_not_found')];
    }

  }


  public static function removeCategory($id)
  {

    return ['ok' => Category::where('id', $id)->delete()];
  }


  public static function getTree($category)
  {
    $tree = [$category];

    if ($category) {

      while ($category->parent_id > 0) {
        $category = Category::select('id', 'title', 'url', 'parent_id')->where('id', $category->parent_id)->first();

        if ($category) {
          $tree[] = $category;
        }
        else{
          break;
        }
        
      }

    }
    $tree[] = ['id'=>0, 'title'=>'منو های اصلی', 'parent_id'=>0];

    return array_reverse($tree);
  }

}
