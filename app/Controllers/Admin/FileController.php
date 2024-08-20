<?php
namespace App\Controllers\Admin;

use Webrium\Upload;
use App\Models\File;

class FileController
{

    public function saveFile()
    {
        $type = input('type', 'other'); // product | blog | other...
        $category = input('category', false); // like product id

        if ($category == false) {
            $category = 'files/'. date('Y') . '/' . date('m');
        }

        $save_dir = "content/$type/$category";
        $save_path = public_path($save_dir);

        $file = new Upload('file');

        $ext = $file->extension();

        $file->path($save_path);
        if (in_array($ext, ['png', 'jpg'])) {
            $file->maxSize(1024);
        } else {
            $file->maxSize(1024 * 50);
        }

        $name = $file->getClientOriginalName();
        $name = str_replace(' ', '-', $name);
        $file->name($name);

        $file->save();

        if ($file->status()) {
            File::new($file->name(), $save_path, $ext);
        }


        return ['ok' => $file->status(), 'name' => $file->name(), 'path' => $save_dir];
    }


}