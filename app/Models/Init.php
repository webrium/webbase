<?php
namespace App\Models;

use App\Models\Admin\Admin;
use App\Models\File;

// use App\Models\Ca;

class Init
{

    public function start()
    {
        $this->createAllTables();

        return '# Start init project';
    }

    public function createAllTables()
    {
        $admin = new Admin;
        $admin->createTable();
        $admin->insertMainAdmin();

        (new Captcha)->createTable();
        (new Category)->createTable();
        (new Product)->createTable();
        (new ProductContent)->createTable();
        (new ProductCategory)->createTable();
        (new File)->createTable();
        (new Post)->createTable();
        (new View)->createTable();
        (new User)->createTable();
        (new User)->createTable();
        (new ProductType)->createTable();
        (new ProductInventory)->createTable();
    }

    public static function setSiteControlAccess($domain = '*')
    {


        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: $domain");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }


        header('CUSTOM-REQUEST: ' . $domain);

    }


}
