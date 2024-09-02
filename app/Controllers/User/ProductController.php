<?php
namespace App\Controllers\User;

use App\Models\Category;
use App\Models\Product;
use App\Models\File;
use App\Models\ProductCategory;
use App\Models\ProductContent;
use App\Models\ProductInventory;
use App\Models\ProductType;
use Webrium\FormValidation;

class ProductController
{

    public function productInfo()
    {
        $code = input('code');
        $url = input('title');

        $product_inventorys = [];
        $product_contents = [];
        $product = Product::where('code', $code)->and('url', $url)->first();

        if ($product) {
            File::makeImageUrlField($product);
            $product_inventorys = ProductInventory::where('product_id', $product->id)->where('amount', '>', 0)->get();
            $product_contents = ProductContent::where('product_id', $product->id)->oldest()->get();
        }

        return [
            'ok' => $product ? true : false,
            'product' => $product,
            'inventorys' => $product_inventorys,
            'contents' => $product_contents,
        ];
    }


}