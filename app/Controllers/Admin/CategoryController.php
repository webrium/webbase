<?php
namespace App\Controllers\Admin;

use App\Models\Category;
use Webrium\FormValidation;

class CategoryController
{

    public function saveNew()
    {
        $id = input('id');
        $title = input('title');
        $url = input('url');
        $parent_id = input('parent_id', 0);

        $form = new FormValidation;
        $form->field('title')->required()->min(3);
        $form->field('url')->required()->min(3);
        $form->field('parent_id')->required()->numeric();
        $form->field('id')->numeric();

        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }

        return Category::store($id, $title, $url, $parent_id);
    }


    public function update()
    {
        $title = input('title');
        $change = input('change');

        $form = new FormValidation;
        $form->field('title')->required()->min(3);

        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }

        return Category::updateCategory($title, $change);
    }


    public function remove()
    {
        $id = input('id');
        return Category::removeCategory($id);
    }

    


    public function getList(){
        $search = input('search', '');
        $order = input('order', 'desc');
        $id = input('id', 0);

        $category = Category::where('id', $id)->first();

        if($order == 'desc'){
            $list = Category::latest();
        }
        else{
            $list = Category::oldest();
        }

        if($category){
            $list->where('parent_id', $category->id);
        }
        else{
            $list->where('parent_id', 0);
        }


        if(empty($search)==false){
            $list = $list->like('title', "%$search%");
        }

        $tree = Category::getTree($category);
        
        return [
            'ok'=>true,
            'tree'=>$tree,
            'list'=>$list->paginate(),
            'category'=>$category,
        ];
    }

}