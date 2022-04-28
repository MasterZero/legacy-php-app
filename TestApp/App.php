<?php

namespace TestApp;


class App
{

    protected static $_config = [];


    public static function init($init_config)
    {
        static::$_config = $init_config;

        DB::init(static::config('db_host'),
            static::config('db_name'),
            static::config('db_user'),
            static::config('db_password'));
    }


    public static function config($key = null)
    {
        return is_string($key) ? static::$_config[$key] : static::$_config;
    }

};



