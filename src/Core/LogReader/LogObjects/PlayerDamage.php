<?php
namespace Core\LogReader\LogObjects;


use Core\Objects\PlayerName;

class PlayerDamage extends LogObject
{
    private $guid_loser;
    private $id_loser;
    private $team_loser;
    private $name_loser;

    private $guid_winner;
    private $id_winner;
    private $team_winner;
    private $name_winner;

    private $weapon;
    private $damage;
    private $mod;
    private $body;

    public function __construct(int $time, array $message)
    {
        $this->guid_loser = $message[1];
        $this->id_loser = $message[2];
        $this->team_loser = $message[3];
        $this->name_loser = new PlayerName($message[4]);
        $this->guid_winner = $message[5];
        $this->id_winner = $message[6];
        $this->team_winner = $message[7];
        $this->name_winner = new PlayerName($message[8]);
        $this->weapon = $message[9];
        $this->damage = $message[10];
        $this->mod = $message[11];
        $this->body = $message[12];

        parent::__construct($time);
    }

    /**
     * @return string
     */
    public function getGuidLoser()
    {
        return $this->guid_loser;
    }

    /**
     * @return string
     */
    public function getIdLoser()
    {
        return $this->id_loser;
    }

    /**
     * @return string
     */
    public function getTeamLoser()
    {
        return $this->team_loser;
    }

    /**
     * @return PlayerName
     */
    public function getNameLoser()
    {
        return $this->name_loser;
    }

    /**
     * @return string
     */
    public function getGuidWinner()
    {
        return $this->guid_winner;
    }

    /**
     * @return string
     */
    public function getIdWinner()
    {
        return $this->id_winner;
    }

    /**
     * @return string
     */
    public function getTeamWinner()
    {
        return $this->team_winner;
    }

    /**
     * @return PlayerName
     */
    public function getNameWinner()
    {
        return $this->name_winner;
    }

    /**
     * @return string
     */
    public function getWeapon()
    {
        return $this->weapon;
    }

    /**
     * @return string
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * @return string
     */
    public function getMod()
    {
        return $this->mod;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}