<?php
namespace App\Controllers\User;

use App\Models\Captcha;
use App\Models\Category;
use App\Models\Product;
use App\Models\File;
use App\Models\ProductCategory;
use App\Models\ProductContent;
use App\Models\ProductInventory;
use App\Models\ProductType;
use App\Models\Sms;
use App\Models\Card;
use Webrium\FormValidation;
use Webrium\Hash;
use App\Models\User;
use Webrium\Http;

class CardController
{

    public function addToCard(){
        $inventory_id = input('product_id');
        
        $inventory = ProductInventory::where('id', $inventory_id)->first();


        $card = Card::where('id', $inventory_id)->find();

        if($card == false){
            $card = new Card;
            $card->amount = 1;
        }
        else{
            if($inventory->amount > $card->amount){
                $card->amount += 1;
            }
        }

        $user = User::$user;

        $card->user_id = $user->id;
        $card->product_id = $inventory->product_id;
        $card->inventory_id = $inventory->id;
        $card->save();

        return['ok'=>true];
    }

}