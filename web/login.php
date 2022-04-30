<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;


if (!Auth::user()) {
    Auth::login($_POST['login'] ?? '', $_POST['password'] ?? '');
}

return redirect_back();
