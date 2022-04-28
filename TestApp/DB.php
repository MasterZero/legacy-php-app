<?php


namespace TestApp;

use PDO;

class DB
{

    protected static $_pdo = null;


    public static function init($host, $name, $user, $password)
    {
        static::$_pdo = new PDO("mysql:host=$host;dbname=$name", $user, $password);
        // enable pdo erros
        static::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public static function raw($request, $params = [])
    {
        $stmt = static::$_pdo->prepare($request);
        $stmt->execute($params);
    }


    public static function fetchAll($request, $params = [])
    {
        $stmt = static::$_pdo->prepare($request);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }


    public static function fetch($request, $params = [])
    {
        $stmt = static::$_pdo->prepare($request);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute($params);
        return $stmt->fetch();
    }


    public static function insert($tableName, $columns)
    {
        $fields = [];
        $values = [];

        foreach($columns as $key => $value) {
            $fields[] = "`$key`";
            $values[] = '?';
        }
        $params = array_values($columns);
        $request = 'INSERT INTO `' . $tableName . '` ( ' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';
        DB::raw($request, $params);
        return static::$_pdo->lastInsertId();
    }

};

