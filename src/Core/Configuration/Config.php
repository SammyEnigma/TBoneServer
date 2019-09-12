<?php


namespace Core\Configuration;

/**
 * Class Config
 *
 * Generic Config class
 *
 * @package Core\Configuration
 */
class Config
{
    /**
     * @var $setting Config
     */
    public static $setting;
    private $main;

    public function __construct()
    {
        require_once ("ConfigurationLoader.php");
        require_once ("MainConfig.php");

        $this->main = new MainConfig();
    }

    /**
     * Get Main Configuration file
     * @return MainConfig mainConfig
     */
    public function main() : MainConfig
    {
        return $this->main;
    }
}