<?php
namespace TestApp\Model;


use TestApp\SimpleORM;


class Record extends SimpleORM
{
    public static $table = 'records';


    protected function loadChilds()
    {
        $this->childs = static::whereAll('`parent_id`=?', [$this->id]);

        foreach($this->childs as $child) {
            $child->loadChilds();
        }
    }

    public static function asTree()
    {
        $roots = static::whereAll('`parent_id` IS NULL');

        foreach($roots as $root) {
            $root->loadChilds();
        }

        return $roots;
    }

};

