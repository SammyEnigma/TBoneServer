<?php


namespace Core\Objects;


class PlayerName
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}