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
     * @param string $data
     * @return bool
     */
    public function sendCommand(string $command, string &$data) : bool;

    /**
     * Kick
     * @param $id int IngameID
     * @param $reason String Reason
     * @param bool $spoof True in case of a spoofer
     * @return bool Succeeded
     */
    public function kick($id, $reason, $spoof = false);

    /**
     * Public Message
     * @param $message String message
     * @return bool Succeeded
     */
    public function publicMessage($message);

    /**
     * Private Message
     * @param $id
     * @param $message
     * @return bool Succeeded
     */
    public function privateMessage($id, $message);

    /**
     * Status Query
     * @param $ip String IPAddress
     * @param $port int Port
     * @return bool Succeeded
     */
    public function statusQuery($ip, $port);

    /**
     * OnInitGame Function (called from the LogHandler)
     * @param $settings array Settings
     */
    public function onInitGame($time, $settings);

    /**
     * Get Amount of private slots
     * @return int Slots
     */
    public function getPrivateSlots();

    /**
     * Get server Version
     * @return string server Version
     */
    public function getVersion();

    /**
     * Print a banner ingame
     * @param $text string text of the banner
     */
    public function printBanner($text);

    /**
     * @deprecated Next version to be deleted
     * Tell Legacy function
     * @param $id
     * @param $message
     */
    public function tell($id,$message);

    /**
     * Say dummy function
     * @deprecated next version to be deleted
     * @param $message
     */
    public function say($message);

    /**
     * Get Current map of the gamserver
     * @return string map
     */
    public function getCurrentMap();

    /**
     * Get current gametype of the server
     * @return string gametype
     */
    public function getCurrentGameType();

    /**
     * Get current rotation of the server
     * @return string rotationstring
     */
    public function getRotation();
}