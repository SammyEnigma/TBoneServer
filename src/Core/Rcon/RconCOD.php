<?php
namespace Core\Rcon;

use Core\Configuration\Config;

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

    private $bot;
    private $hostname;

    private $totalSlots;
    private $privateSlots;
    private $version;

    private $mapRotation;
    private $currentMap;
    private $currentGameType;

    /**
     * RconCOD constructor.
     */
    public function __construct()
    {
        $this->bot = Config::$setting->main()->get("bot");
        $this->connect();
        $this->initData();
    }

    /**
     * Connect to server
     */
    protected function connect()
    {
        $this->connection = fsockopen("udp://" . Config::$setting->main()->get("rcon_host"), Config::$setting->main()->get("rcon_port"), $errno, $errstr, 1);
        if(!$this->connection) {
            die("Rcon connection closed with error: " . $errno . ": " . $errstr);
        }

        socket_set_timeout($this->connection, 1, 1);
    }

    /**
     * Send a rcon command to the server
     * @param string $command
     * @param string $data
     * @return bool
     */
    public function sendCommand(string $command, &$data): bool
    {

        //Write data
        $written = fwrite($this->connection, "\xFF\xFF\xFF\xFFrcon ".Config::$setting->main()->get("rcon_password")." ".$command."\x00");
        if($written === false){
            return false;
        }

        //Read data
        $output = fread ($this->connection, 1);
        if(!empty($output)) {
            do {
                $statusPre = socket_get_status($this->connection);
                $output = $output . fread($this->connection, 1);
                $statusPost = socket_get_status($this->connection);
            } while ($statusPre["unread_bytes"] != $statusPost["unread_bytes"]);

            switch ($command) {
                case "status":
                    $data = $output;
                    return true;
                case "teamstatus":
                    $data = $output;
                    return true;
                case "":
                    $data = str_replace("\n", "", $output);
                    return true;
                default:
                    $output = str_replace("^7", "", $output);
                    $line = explode("\n", $output);
                    $domain = explode('"', $line[1]);
                    if (isset($domain[3])) {
                        $data = $domain[3];
                    } else {
                        $data = $domain[0];
                    }
                    return true;
            }
        }

        return false;
    }

    /**
     * Getting data on startup of the class
     */
    protected function initData()
    {
        $this->sendCommand("sv_hostname", $this->hostname );
        print("Hostname: ".$this->hostname."\n");
        $this->sendCommand("sv_maxclients", $this->totalSlots);
        print("TotalSlots: ".$this->totalSlots."\n");
        $this->sendCommand("sv_privateClients", $this->privateSlots);
        print("PrivateSlots: ".$this->privateSlots."\n");
        $this->sendCommand("sv_maprotation", $this->mapRotation);
        print("MapRotation: ".$this->mapRotation."\n");
        $this->sendCommand("mapname", $this->currentMap);
        print("CurrentMap: ".$this->currentMap."\n");
        $this->sendCommand("g_gametype", $this->currentGameType );
        print("Current GameType: ".$this->currentGameType."\n");
        $this->sendCommand("version", $this->version);
        print("Server version: ".$this->version."\n");

        $this->publicmessage("Starting Tbone Server ".VERSION. " ");
    }

    /**
     * Kick
     * @param $id int IngameID
     * @param $reason String Reason
     * @param bool $spoof True in case of a spoofer
     * @return bool Succeeded
     */
    public function kick($id, $reason, $spoof = false)
    {
        // TODO
    }

    /**
     * Public Message
     * @param $message String message
     * @return bool Succeeded
     */
    public function publicMessage($message)
    {
        return $this->sendCommand("say ".$this->bot." ".$message, $data);
    }

    /**
     * Private Message
     * @param $id
     * @param $message
     * @return bool Succeeded
     */
    public function privateMessage($id, $message)
    {
        // TODO: Implement privateMessage() method.
    }

    /**
     * Status Query
     * @param $ip String IPAddress
     * @param $port int Port
     * @return bool Succeeded
     */
    public function statusQuery($ip, $port)
    {
        // TODO: Implement statusQuery() method.
    }

    /**
     * OnInitGame Function (called from the LogHandler)
     * @param $settings array Settings
     */
    public function onInitGame($time, $settings)
    {
        // TODO: Implement onInitGame() method.
    }

    /**
     * Get Amount of private slots
     * @return int Slots
     */
    public function getPrivateSlots()
    {
        // TODO: Implement getPrivateSlots() method.
    }

    /**
     * Get server Version
     * @return string server Version
     */
    public function getVersion()
    {
        // TODO: Implement getVersion() method.
    }

    /**
     * Print a banner ingame
     * @param $text string text of the banner
     */
    public function printBanner($text)
    {
        // TODO: Implement printBanner() method.
    }/**
 * @param $id
 * @param $message
 * @deprecated Next version to be deleted
 * Tell Legacy function
 */
    public function tell($id, $message)
    {
        // TODO: Implement tell() method.
    }

    /**
     * Say dummy function
     * @param $message
     * @deprecated next version to be deleted
     */
    public function say($message)
    {
        // TODO: Implement say() method.
    }

    /**
     * Get Current map of the gamserver
     * @return string map
     */
    public function getCurrentMap()
    {
        // TODO: Implement getCurrentMap() method.
    }

    /**
     * Get current gametype of the server
     * @return string gametype
     */
    public function getCurrentGameType()
    {
        // TODO: Implement getCurrentGameType() method.
    }

    /**
     * Get current rotation of the server
     * @return string rotationstring
     */
    public function getRotation()
    {
        // TODO: Implement getRotation() method.
    }
}