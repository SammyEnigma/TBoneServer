<?php

namespace Core\Rcon;

/**
 * Class Rcon
 * @package Core\Rcon
 */
class Rcon
{
    private $gameRcon;

    /**
     * Rcon constructor.
     */
    public function __construct()
    {
        require_once ("RconInterface.php");
        require_once ("RconCOD.php");

        //For now we only have 1 game, in the future we can extend this?
        $this->gameRcon = new RconCOD();
    }

    /**
     * @return RconInterface
     */
    public function get() : RconInterface
    {
        return $this->gameRcon;
    }
}