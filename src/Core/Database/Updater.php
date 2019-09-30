<?php

namespace src\Core\Database;


use Core\Configuration\Config;
use Medoo\Medoo;

class Updater
{
    private $currentVersion = 0;
    private $mysql;

    public function __construct(Medoo &$mysql)
    {
        $this->mysql = $mysql;

        //Check if table exists and start updating from this point
        if($this->mysql->has("information_schema.tables", array("table_schema" => Config::$setting->main()->get("db_database"), "table_name" => "version")))
        {
            $this->currentVersion = $this->mysql->get("version")["version"];
        } else {
            require_once ("./Core/Database/updater_1.php");
            new Updater_1($mysql);
        }
    }
}