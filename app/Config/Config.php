<?php
use Webrium\App;
use Webrium\Session;
use Webrium\Directory;
use App\Models\Init;

// sessions save directory
Session::set_path(Directory::path('sessions'));
App::setLocale('fa');

Init::setSiteControlAccess('http://127.0.0.1:5173');