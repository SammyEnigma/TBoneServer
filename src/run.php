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
require_once ("Core/LogReader/Callbacks/CallbackFunction.php");
require_once ("Core/LogReader/Callbacks/CallbackRegister.php");

require_once ("Core/LogReader/LogObjects/LogObjectInterface.php");
require_once ("Core/LogReader/LogObjects/LogObject.php");

require_once ("Core/LogReader/LogObjects/PlayerJoin.php");
require_once ("Core/LogReader/LogObjects/PlayerDisconnect.php");
require_once ("Core/LogReader/LogObjects/PlayerKill.php");
require_once ("Core/LogReader/LogObjects/PlayerSay.php");
require_once ("Core/LogReader/LogObjects/PlayerSayTeam.php");

require_once ("Core/LogReader/LogObjects/InitGame.php");
require_once ("Core/LogReader/LogObjects/ShutdownGame.php");

require_once ("Core/Commands/CommandHandler.php");

Core\Configuration\Config::$setting = new Core\Configuration\Config();
$rcon = new \Core\Rcon\Rcon();

$gamesLog = new \Core\LogReader\GamesLog();

$commandHandler = new \Core\Commands\CommandHandler($gamesLog->getCallbackRegister(), $rcon);

$gamesLog->run();

