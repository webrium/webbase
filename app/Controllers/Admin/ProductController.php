<?php
namespace App\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductContent;
use App\Models\ProductInventory;
use App\Models\ProductType;
use Webrium\FormValidation;

class ProductController
{

    public function save()
    {

        $product_input = input('product');
        $inventories_input = input('inventories');


        // return input();
        $form = new FormValidation($product_input);
        $form->field('id')->numeric();
        $form->field('title')->required()->min(3);
        $form->field('url')->required()->min(3);
        $form->field('code')->string()->min(3);
        $form->field('description')->string()->min(3);
        $form->field('image_id')->numeric();
        $form->field('ages')->numeric();
        // $form->field('producer_id')->numeric();
        // $form->field('active')->required()->();


        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }


        $product = Product::find($product_input['id']??0);

        if ($product == false) {
            $product = new Product;
        }

        foreach($product_input as $param_name=> $value){

            if(isset($param_name['id'])==false){
                $product->{$param_name} = $value;
            }
        }

        $product->save();

        foreach($inventories_input as $inventory){
            if(isset($inventory['id'])){
                $product_inventory = ProductInventory::find($inventory['id']);
            }
            else{
                $product_inventory = new ProductInventory;
                $product_inventory->product_id = $product->id;
            }

            foreach($inventory as $param_name=> $value){

                if(isset($param_name['id'])==false && isset($param_name['product_id'])==false){
                    $product_inventory->{$param_name} = $value;
                }
            }

    
            $product_inventory->save();
        }



        return ['ok' => true,];
    }





    public function remove()
    {
        $id = input('id');
        Product::where('id', $id)->delete();

        return ['ok' => true];
    }


    public function getProductInfo()
    {
        $id = input('id', 0);

        $product = Product::find($id);
        $product_types = ProductType::latest()->get();

        return [
            'ok' => true,
            'product' => $product,
            'product_types' => $product_types,
        ];
    }


    public function saveProductContent()
    {
        $form = new FormValidation;
        $form->field('id')->numeric();
        $form->field('product_id')->numeric();
        $form->field('content')->string()->min(3);
        $form->field('path')->string();
        $form->field('description')->string()->min(3);
        $form->field('type')->required()->string();
        $form->field('active')->required()->numeric();

        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }


        $id = input('id', 0);
        $product_id = input('product_id');
        $content = input('content');
        $path = input('path');
        $description = input('description');
        $type = input('type');
        $active = input('active', 1);

        $productContent = ProductContent::find($id);

        if ($productContent == false) {
            $productContent = new ProductContent;
        }

        $productContent->product_id = $product_id;
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

        if (Product::where('id', $product_id)->doesntExist()) {
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



    public function saveProductType()
    {
        $form = new FormValidation;
        $form->field('id')->numeric();
        $form->field('title')->string()->min(3);
        $form->field('label')->string()->min(3);


        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }


        $id = input('id', 0);
        $title = input('title');
        $label = input('label');


        $productType = ProductType::find($id);

        if ($productType == false) {
            $productType = new ProductType;
        }

        $productType->title = $title;
        $productType->label = $label;
        $productType->save();

        return ['ok' => true, 'product_content' => $productType->toObject()];
    }

    public function removeProductType()
    {
        $id = input('id');
        ProductType::where('id', $id)->delete();
        return ['ok' => true];
    }


    public function productTypes()
    {
        $search = input('search', '');
        $order = input('order', 'desc');

        if ($order == 'desc') {
            $types = ProductType::latest();
        } else {
            $types = ProductType::oldest();
        }

        if (empty($search) == false) {
            $types = $types->like('title', "%$search%");
        }

        return [
            'ok' => true,
            'types' => $types->paginate(),
        ];
    }
    public function productCategorys()
    {
        $search = input('search', '');
        $order = input('order', 'desc');

        if ($order == 'desc') {
            $categorys = ProductCategory::latest();
        } else {
            $categorys = ProductCategory::oldest();
        }

        if (empty($search) == false) {
            $categorys = $categorys->like('title', "%$search%");
        }

        return [
            'ok' => true,
            'categorys' => $categorys->paginate(),
        ];
    }


}