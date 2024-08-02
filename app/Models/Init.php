<?php
namespace App\Models;
use App\Models\Admin\Admin;
use App\Models\Ca;

class Init {

    public function start(){
        $this->createAllTables();

        return '# Start init project';
    }

    public function createAllTables(){
        $admin = new Admin;
        $admin->createTable();
        $admin->insertMainAdmin();

        (new Captcha)->createTable();
    }


}
