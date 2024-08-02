<?php

use App\Models\Admin\Admin;

function checkAdminAuth(){
    $result = Admin::checkAuth();
    return $result;
}


function roleAdmin(){
    $admin = Admin::current();

    if($admin->role != 'admin'){
        return ['ok'=>false, 'message'=>lang('message.not_access_op')];
    }

    return ['ok'=>true];
}
