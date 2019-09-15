<?php
namespace Core\LogReader\LogObjects;


class InitGame extends LogObject
{
    protected $settings;

    /**
     * InitGame constructor.
     * @param int $time
     * @param array $settings
     */
    public function __construct(int $time, array $settings)
    {
        $this->settings = $settings;

        parent::__construct($time);
    }

    /**
     * @param String $parameter
     * @return string
     */
    public function getSettings(String $parameter) : string
    {
        return $this->settings[$parameter];
    }
}