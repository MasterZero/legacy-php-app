<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;


if (Auth::user()) {
    Auth::logout();

}

return redirect_back();
