<?php

use App\Models\Admin\Admin;

function checkAdminAuth(){
    return Admin::checkAuth();
}