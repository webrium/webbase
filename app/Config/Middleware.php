<?php

use App\Models\Admin\Admin;
use App\Models\User;
use Webrium\App;
use Webrium\FormValidation;

function checkAdminAuth(){
    $result = Admin::checkAuth();
    if($result == false){
        App::ReturnData(['ok'=>false, 'message'=>'pleas auth']);
        die;
    }
    return $result;
}


function roleAdmin(){
    $admin = Admin::current();

    if($admin->role != 'admin'){
        App::ReturnData(['ok'=>false, 'message'=>lang('message.not_access_op')]);
        die;
    }
    else{
        return true;
    }
}

function adminOtherThanMyself(){
    $admin = Admin::current();
    $admin_id = input('admin_id');

    $form = new FormValidation;
    $form->field('admin_id')->required()->numeric();

    if($form->isValid() == false){
        App::ReturnData(['ok'=>false, 'message'=>$form->getFirstErrorMessage()]);
        die;
    }

    if($admin_id == $admin->id){
        App::ReturnData(['ok'=>false, 'message'=>lang('message.other_than_your_account')]);
        die;
    }

    return true;
}



function checkUserAuth(){
    $result = User::checkAuth();
    
    if($result == false){
        App::ReturnData(['ok'=>false, 'message'=>'pleas auth']);
        die;
    }
    return $result;
}
