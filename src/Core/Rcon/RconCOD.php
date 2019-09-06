<?php
namespace Core\Rcon;

/**
 * Class RconCOD
 *
 * Rcon for the Call of Duty Games
 *
 * @package Core\Rcon
 */
class RconCOD implements RconInterface
{
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    protected function connect()
    {
        $this->connection = fsockopen("udp://localhost", 28960, $errno, $errstr, 1);
        if(!$this->connection) {
            die("Rcon connection closed with error: " . $errno . ": " . $errstr);
        }
    }

    /**
     * Send a rcon command to the server
     * @param string $command
     * @return bool
     */
    public function sendCommand(string $command): bool
    {
        $written = fwrite($this->connection, "\xFF\xFF\xFF\xFFrcon password ".$command."\x00");
        if($written === false){
            return false;
        }

        return true;
    }
}