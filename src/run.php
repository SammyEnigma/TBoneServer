<?php
/**
 * Tbone Main class
 */

require_once("../vendor/autoload.php");

require_once ("Core/Configuration/Config.php");
require_once ("Core/Rcon/Rcon.php");

$config = new \src\Core\Configuration\Config();
$rcon = new \Core\Rcon\Rcon();
