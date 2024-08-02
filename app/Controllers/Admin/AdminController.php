<?php
namespace App\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Captcha;
use Webrium\Hash;
use Webrium\Http;
use Webrium\FormValidation;

class AdminController
{

    public function createNewAdmin()
    {

        // $role = roleAdmin();
        // if ($role['ok'] == false) {
        //     return $role;
        // }

        $form = new FormValidation;
        $form->field('name')->required()->min(3)->max(30)
            ->field('username')->required()->min(3)->max(25)
            ->field('password')->required()->min(6)->confirmed('confirm_password')
            ->field('role')->string()->required();

        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }

        $name = input('name');
        $username = input('username');
        $password = input('password');
        $role = input('role');

        $new_admin = Admin::where('username', $username)->find();

        if ($new_admin) {
            return ['ok' => false, 'message' => lang('message.duplicate_username')];
        }

        $new_admin = Admin::new($name, $username, $password, $role);

        return ['ok' => true, 'admin_id' => $new_admin->id];
    }


    public function updateAdmin()
    {

        $form = new FormValidation;
        $form->field('name')->min(3)->max(30)
            ->field('username')->min(3)->max(25)
            ->field('password')->min(6)->confirmed('confirm_password');


        if ($form->isValid() == false) {
            return ['ok' => false, 'message' => $form->getFirstErrorMessage()];
        }

        $name = input('name', false);
        $username = input('username', false);
        $password = input('password', false);
        $admin_id = input('admin_id', false);

        if ($admin_id && Admin::current()->role == 'admin') {
            $update_admin = Admin::find($admin_id);

            if ($update_admin == false) {
                return ['ok' => false, 'message' => lang('information_not_found')];
            }
        } else {
            $update_admin = Admin::current();
        }


        if ($name) {
            $update_admin->name = $name;
        }

        if ($username) {
            if (Admin::where('username', $username)->first() == false) {
                $update_admin->username = $username;
            } else {
                return ['ok' => false, 'message' => lang('message.duplicate_username')];
            }
        }

        if ($password) {
            $update_admin->password = Hash::make($password);
        }

        return ['ok' => true];
    }


    public function remove(){

        $admin_id = input('admin_id');

        if($admin_id != Admin::current()->id){
            Admin::where('id', $admin_id)->delete();
            return ['ok'=>true];
        }
        else{
            return ['ok'=>false, 'message'=>lang('message.not_access_op')];
        }
    }
}