<?php
namespace Core\LogReader\LogObjects;


use Core\Objects\PlayerName;

class PlayerSayTeam extends LogObject
{
    private $slot;
    private $guid;
    private $name;
    private $text;

    public function __construct(int $time, $slot, $guid, $name, $text)
    {
        $this->slot = $slot;
        $this->guid = $guid;
        $this->name = new PlayerName($name);
        $this->text = $text;
        parent::__construct($time);
    }

    /**
     * @return int
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @return PlayerName
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}