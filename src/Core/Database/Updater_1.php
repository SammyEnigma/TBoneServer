<?php

namespace src\Core\Database;


use Medoo\Medoo;

class Updater_1
{
    public function __construct(Medoo &$mysql)
    {
        $mysql->create("version", array("version" => array("INT(1)")));
        $mysql->insert("version", array("version" => 1));
    }
}