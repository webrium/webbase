<?php
namespace App\Controllers\Admin;

use App\Models\Category;
use Webrium\FormValidation;

class CategoryController
{

    public function saveNew()
    {
        $title = input('title');
        $link_to = input('link_to', 0);

        $form = new FormValidation;
        $form->field('title')->required()->min(3);

        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }

        return Category::new($title, $link_to);
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




}