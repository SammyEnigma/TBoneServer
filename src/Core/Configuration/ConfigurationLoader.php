<?php


namespace Core\Configuration;

/**
 * Class ConfigurationLoader
 * @package Core\Configuration
 */
class ConfigurationLoader
{
    /**
     * Load Config File
     * @param string $config Location
     * @param array $data
     * @return bool
     */
    public static function getConfigFile(string $config, array &$data) : bool
    {
        $config_location = $config.".tbone";
        if(file_exists($config_location)) {
            $fh = fopen($config_location, "r");

            while (!feof($fh)) {
                $get = fgets($fh);
                $line = explode("=", trim($get), 2);
                $line[0] = preg_replace("/\\s/", "", $line[0]);

                //0 = var name
                //1 = value
                if($line[0] != "") {
                    $line[1] = substr($line[1], 1);
                    $data[$line[0]] = $line[1];
                }
            }

            return true;
        }

        return false;
    }

}