<?php
namespace Core\Commands;

use Core\LogReader\Callbacks\CallbackRegister;
use Core\LogReader\LogObjects\PlayerSay;
use Core\Rcon\Rcon;

class CommandHandler
{
    private $rcon;
    private $commands;

    public function __construct(CallbackRegister $gamesLogCallback, Rcon &$rcon)
    {
        $this->rcon = $rcon;

        $gamesLogCallback->register($this, "onSay");

        $dir = opendir("./Core/Commands");

        while(false !== ($file = readdir($dir))) {
            if($file != "." && $file != ".." && $file != "CommandHandler.php") {
                require_once ("./Core/Commands/".$file);
                $command = str_replace(".php", "", $file);

                //Generate class
                try {
                    $rc = new \ReflectionClass($command);
                    $this->commands[$command] = $rc->newInstance();
                } catch (\Exception $exception) {
                    print("Failed to load command: ". $command);
                }
            }
        }
    }

    public function onSay(PlayerSay $playerSay)
    {
        print($playerSay->getName().": ". $playerSay->getText());
    }
}