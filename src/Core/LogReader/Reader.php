<?php

namespace Core\LogReader;

use src\Core\LogReader\CallbackFunction;

/**
 * Class Reader
 *
 * Reader interface for all log files
 *
 * @package Core\LogReader
 */
abstract class Reader
{
    protected $logFileSize;
    protected $logLocation;
    protected $callbackRegister;

    /**
     * Reader constructor.
     * @param string $logLocation
     */
    public function __construct(string $logLocation)
    {
        $this->logLocation = $logLocation;
        $this->callbackRegister = new CallbackRegister();
        $this->callbackRegister->addCallBack(CallbackFunction::onTick);

        if(!file_exists($this->logLocation))
        {
            print($this->logLocation);
            die("Invalid log location");
        }

        clearstatcache();
        $this->logFileSize = filesize($this->logLocation);
    }

    /**
     * Read new lines from the log file
     */
    protected function getLines()
    {
        if(file_exists($this->logLocation))
        {
            $fh = fopen($this->logLocation, "r");
            fseek($fh, $this->logFileSize, SEEK_SET);

            $newLines = array();

            while(!feof($fh)) {
                $get = fgets($fh);
                if($get === false) {
                    break;
                }

                $this->logFileSize += strlen($get);
                $newLines[] = $get;
            }

            fclose($fh);

            foreach($newLines as $line) {
                $this->readLine($line);
            }

            unset($newLines);

            $this->callbackRegister->doCallBacks(CallbackFunction::onTick, null);
        } else {
            $this->logFileSize = 0;
        }
    }

    /**
     * Read / Parse logfile line
     * @param $line String Line
     */
    protected abstract function readLine($line);

    /**
     * Get filesize of log
     * @return int
     */
    public function getLogFileSize()
    {
        return $this->logFileSize;
    }

    /**
     * Getter for callbacks
     * @return CallbackRegister
     */
    public function getCallbackRegister()
    {
        return $this->callbackRegister;
    }
}