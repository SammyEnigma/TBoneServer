<?php
namespace Core\LogReader\LogObjects;

use Core\Objects\PlayerName;

class PlayerDisconnect extends LogObject
{
    private $name;
    private $guid;
    private $slot;

    public function __construct(int $time, PlayerName $name, string $guid, int $slot)
    {
        $this->name = $name;
        $this->guid = $guid;
        $this->slot = $slot;
        parent::__construct($time);
    }

    /**
     * @return PlayerName
     */
    public function getName(): PlayerName
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @return string
     */
    public function getSlot(): string
    {
        return $this->slot;
    }
}