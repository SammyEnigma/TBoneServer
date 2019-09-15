<?php
/**
 * Tbone Main class
 */

define("VERSION", "1.0.0");

require_once("../vendor/autoload.php");

require_once ("Core/Configuration/Config.php");
require_once ("Core/Rcon/Rcon.php");

require_once ("Core/LogReader/Reader.php");
require_once ("Core/LogReader/GamesLog.php");
require_once("Core/LogReader/CallbackFunction.php");
require_once("Core/LogReader/CallbackRegister.php");

Core\Configuration\Config::$setting = new Core\Configuration\Config();
$rcon = new \Core\Rcon\Rcon();

$gamesLog = new \Core\LogReader\GamesLog();
$gamesLog->run();
