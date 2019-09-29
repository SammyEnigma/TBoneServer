<?php
namespace Core\Commands;

use Core\LogReader\Callbacks\CallbackRegister;
use Core\LogReader\LogObjects\PlayerSay;
use Core\Rcon\Rcon;

class CommandHandler
{
    private $rcon;

    public function __construct(CallbackRegister $gamesLogCallback, Rcon &$rcon)
    {
        $this->rcon = $rcon;

        $gamesLogCallback->register($this, "onSay");
    }

    public function onSay(PlayerSay $playerSay)
    {
        print($playerSay->getName().": ". $playerSay->getText());
    }
}