<?php
namespace Core\Rcon;

/**
 * Interface RconInterface
 *
 * Interface to standarize all rcon requests for all the games
 *
 * @package Core\Rcon
 */
interface RconInterface
{
    /**
     * Send a rcon command to the server
     * @param string $command
     * @return bool
     */
    public function sendCommand(string $command) : bool;
}