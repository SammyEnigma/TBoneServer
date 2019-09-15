<?php
namespace Core\LogReader\LogObjects;

/**
 * Class LogObject
 * @package Core\LogReader\LogObjects
 */
abstract class LogObject implements LogObjectInterface
{
    protected $time;

    /**
     * LogObject constructor.
     * @param $time
     */
    public function __construct(int $time)
    {
        $this->time = $time;
    }

    /**
     * @return int Time
     */
    public function getTime()
    {
        return $this->time;
    }
}