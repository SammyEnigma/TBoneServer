<?php


namespace src\Core\Configuration;

/**
 * Class MainConfig
 *
 * Main Configuration Loader
 *
 * @package src\Core\Configuration
 */
class MainConfig
{
    private $data = array();

    public function __construct()
    {
        if(!ConfigurationLoader::getConfigFile("main", $this->data))
        {
            die("Invalid Configuraton File");
        }
    }

    /**
     * Get Setting from config
     * @param string $setting
     * @return string
     */
    public function get(string $setting) : string
    {
        return $this->data[$setting];
    }
}