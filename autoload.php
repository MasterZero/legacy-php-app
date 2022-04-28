<?php

use TestApp\App;

error_reporting(E_ALL);
ini_set("display_errors", "1");
session_start();

$config = include 'config.php';



spl_autoload_register(function ($class_name) {
    $path = str_replace('\\', '/', $class_name);
    include $path . '.php';
});



App::init($config);

include 'helpers.php';


