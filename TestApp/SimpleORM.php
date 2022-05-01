<?php
namespace TestApp;

use JsonSerializable;


class SimpleORM implements JsonSerializable
{

    protected $db_data = [];

    public static $table = '';

    public function __construct($db_data = [])
    {
        $this->db_data = $db_data;
    }

    public function __set($name, $value)
    {
        return $this->db_data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->db_data[$name];
    }

    public static function all()
    {
        $ret = [];
        $data = DB::fetchAll('SELECT * FROM `' . static::$table . '`');

        foreach($data as $row) {
            $ret[] = new static($row);
        }

        return $ret;
    }

    public static function whereAll($statement, $params = [])
    {
        $data = DB::fetchAll('SELECT * FROM `' . static::$table . '` WHERE ' . $statement, $params);
        $ret = [];
        foreach($data as $row) {
            $ret[] = new static($row);
        }
        return $ret;
    }

    public static function where($statement, $params = [])
    {
        $data = DB::fetch('SELECT * FROM `' . static::$table . '` WHERE ' . $statement, $params);

        if ($data === false) {
            return false;
        }
        return new static($data);
    }

    public function update($params)
    {

        $columns = [];
        $values = [];

        foreach($params as $key => $value) {

            if ($value == 'null') {
                $columns[] = "`$key`=NULL";
            } else {
                $columns[] = "`$key`=?";
                $values[] = $value;
            }
        }

        $columns = implode(', ', $columns);

        DB::raw('UPDATE ' . static::$table . ' SET ' . $columns . 'WHERE `id`=' . $this->id, $values);
    }


    public static function create($params)
    {
        $columns = [];
        $values = [];
        $paramValues = [];
        foreach($params as $key => $value) {

            $columns[] = "`$key`";
            if ($value == 'null') {
                $values[] = 'NULL';
            } else {
                $values[] = '?';
                $paramValues[] = $value;
            }
        }
        $columns = implode(', ', $columns);
        $values = implode(', ', $values);

        DB::raw('INSERT INTO `' . static::$table . '` (' . $columns . ') VALUES (' . $values . ')', $paramValues);
        return DB::lastId();
    }


    public function delete()
    {
        DB::raw('DELETE FROM `' . static::$table . '` WHERE `id`=?', [$this->id]);
    }

    public static function find($id)
    {
        return static::where('`id`=?', [$id]);
    }

    public function jsonSerialize()
    {
        return $this->db_data;
    }


};



