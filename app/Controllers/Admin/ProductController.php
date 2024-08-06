<?php
namespace App\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductContent;
use Webrium\FormValidation;

class ProductController
{

    public function save()
    {
        $form = new FormValidation;
        $form->field('id')->numeric();
        $form->field('title')->required()->min(3);
        $form->field('url')->required()->min(3);
        $form->field('code')->string()->min(3);
        $form->field('description')->string()->min(3);
        $form->field('price')->required()->numeric();
        $form->field('show_price')->numeric();
        $form->field('image')->string();
        $form->field('ages')->numeric();
        $form->field('producer_id')->numeric();
        $form->field('active')->required()->numeric();


        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }

        $id = input('id', 0);
        $title = input('title');
        $url = input('url');
        $code = input('code');
        $description = input('description');
        $attributes = input('attributes');
        $price = input('price');
        $show_price = input('show_price', 0);
        $image = input('image');
        $ages = input('ages');
        $producer_id = input('producer_id');
        $active = input('active', 0);

        $product = Product::find($id);

        if ($product == false) {
            $product = new Product;
        }

        $product->title = $title;
        $product->url = $url;
        $product->code = $code;
        $product->description = $description;
        $product->attributes = $attributes;
        $product->price = $price;
        $product->show_price = $show_price;
        $product->image = $image;
        $product->ages = $ages;
        $product->producer_id = $producer_id;
        $product->active = $active;
        $product->save();

        return ['ok' => true, 'product' => $product->toObject()];
    }





    public function remove()
    {
        $id = input('id');
        Product::where('id', $id)->delete();

        return ['ok' => true];
    }



    public function saveProductContent()
    {
        $form = new FormValidation;
        $form->field('id')->numeric();
        $form->field('product_id')->min(3);
        $form->field('content')->string()->min(3);
        $form->field('path')->string();
        $form->field('description')->string()->min(3);
        $form->field('type')->required()->string();
        $form->field('active')->boolean();

        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }


        $id = input('id', 0);
        $product_id = input('product_id');
        $content = input('content');
        $path = input('path');
        $description = input('description');
        $type = input('type');
        $active = input('active');

        $productContent = ProductContent::find($id);

        if ($productContent == false) {
            $productContent = new Product;
        }

        $productContent->producer_id = $product_id;
        $productContent->content = $content;
        $productContent->path = $path;
        $productContent->description = $description;
        $productContent->type = $type;
        $productContent->active = $active;
        $productContent->save();

        return ['ok' => true, 'product_content' => $productContent->toObject()];
    }

    public function removeProductContent()
    {
        $id = input('id');
        ProductContent::where('id', $id)->delete();
        return ['ok' => true];
    }



    /**
     * Save product category
     */
    public function saveProductCategory()
    {
        $product_id = input('product_id');
        $category_id = input('category_id');

        $category = Category::find($category_id);

        if ($category == false) {
            return ['ok' => false, 'message' => lang('message.category_not_found')];
        }

        if(Product::where('id', $product_id)->doesntExist()){
            return ['ok' => false, 'message' => lang('message.product_not_found')];
        }

        $product_category = ProductCategory::where('product_id', $product_id)
            ->and('category_id', $category_id)->find();

        if ($product_category == false) {
            $product_category = new ProductCategory;
        }

        $product_category->product_id = $product_id;
        $product_category->category_id = $category_id;
        $product_category->link_to = $category->link_to;
        $product_category->title = $category->title;
        $product_category->save();

        return ['ok' => true, 'product_category' => $product_category->toObject()];
    }


    /**
     * Remove product category
     */
    public function removeProductCategory()
    {
        $id = input('id');

        $row = ProductCategory::where('id', $id)->delete();

        return ['ok' => true, 'row' => $row];
    }


}