<?php
namespace Core\LogReader\LogObjects;

use Core\Objects\PlayerName;

class PlayerJoin extends LogObject
{
    private $name;
    private $guid;
    private $team;

    public function __construct(int $time, PlayerName $name, string $guid, string $team)
    {
        $this->name = $name;
        $this->guid = $guid;
        $this->team = $team;
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
    public function getTeam(): string
    {
        return $this->team;
    }
}