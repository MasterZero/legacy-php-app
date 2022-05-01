<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;


if (!Auth::user()) {
    Auth::login(isset($_POST['login']) ? $_POST['login'] : '',
        isset($_POST['password']) ? $_POST['password'] : '');
}

return redirect_back();
