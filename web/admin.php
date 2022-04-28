<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;


$user = Auth::user();

if (!$user) {
    var_dump('not auth');

    $user = Auth::login('admin2', 'heallyhardpassword1337_2');

    if (!$user) {
        var_dump('bad password');
    }
} else {
    var_dump($user);
    Auth::logout();
}





