<?php
namespace App\Models;

use Foxdb\Model;
use Foxdb\Schema;
use PDate\PDate;
use Webrium\File as Fs;

class File extends Model
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
    $table->string('url');
    $table->string('type', 20);
    $table->timestamps();
    $table->create();

    $table->addColumn()->string('status')->default('temp')->after('type')->change();
  }


  /**
   * Save new file in db
   * @param string $name
   * @param string $path
   * @param string $type
   * @param string $status [permanent|temporary]
   * @return void
   */
  public static function new(string $name, string $url, string $type, string $status = 'temporary'):File
  {
    $file = new File;
    $file->name = $name;
    $file->url = $url;
    $file->type = $type;
    $file->status = $status;
    $file->save();

    self::cleanUp();

    return $file;
  }


  /**
   * It deletes the files that are created temporarily and more than a week has passed since they were uploaded
   * @return int 
   */
  public static function cleanUp()
  {
    $ex_date = PDate::new()
      ->now()
      ->format('Y-m-d 00:00:00')
      ->addDay(-7)
      ->getGregorian();

    $list = File::where('created_at', '<=', $ex_date)->and('status', 'temporary')->get();

    foreach ($list as $key => $file) {
      self::deleteFile($file);
    }

    return count($list);
  }

  public static function deleteFile(File $file){
      // File::where('id', $file->id)->delete();
      // Fs::delete($file->path);
  }


  /**
   * When we want a file to be available forever, we call this function to change the file type to permanent
   * @param int $file_id
   * @return bool
   */
  public static function setPermanentStatus(int $file_id)
  {
    $file = File::find($file_id);

    if ($file) {
      $file->status = 'permanent';
      $file->save();

      return true;
    }

    return false;
  }

  public static function makeImageUrlField(&$item){
    $file = File::find($item->image_id);
    $item->image = "$file->url/$file->name";
  }



}
