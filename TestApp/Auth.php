<?php
namespace TestApp;

use TestApp\Model\User;


class Auth
{

    protected static $user = false;

    public static function hash($password)
    {
        return hash('sha256', $password . App::config('salt'));
    }

    public static function auth($login, $password)
    {
        return User::where('`login`=? AND `password`=?', [$login, static::hash($password)]);
    }

    public static function login($login, $password)
    {
        $user = static::auth($login, $password);
        if ($user === false) {
            return false;
        }

        $_SESSION['id'] = $user->id;
        $_SESSION['login'] = $user->login;

        return $user;
    }

    public static function logout()
    {
        session_unset();
        static::$user = false;
    }

    public static function user()
    {
        if (static::$user) {
            return static::$user;
        }

        if (!isset($_SESSION['id'])) {
            return false;
        }

        return User::find($_SESSION['id']);
    }
};

