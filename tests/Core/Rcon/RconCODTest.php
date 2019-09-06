<?php
use Core\Rcon\RconCOD;

final class RconCODTest extends \PHPUnit\Framework\TestCase
{
    public function testSendCommand()
    {
        $rconCOD = new RconCOD();
        $this->assertIsBool($rconCOD->sendCommand("test"));
    }
}