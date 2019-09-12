<?php
namespace Core\LogReader;

use src\Core\LogReader\CallbackFunction;

/**
 * Class callbackRegister
 *
 * Call back register
 *
 * @package Core\LogReader
 */
class CallbackRegister
{
    private $functionCallbacks = array();
    private $callbacks = array();

    /**
     * Register a class in the callback function
     * @param $class object Class
     * @param $function String function name
     * @return bool Failed/passed
     */
    public function register(&$class, $function)
    {
        global $Console;

        if(in_array($function, $this->functionCallbacks)) {
            if(isset($this->callbacks[$function])) {
                $this->callbacks[$function][] = &$class;
            } else {
                $this->callbacks[$function] = array(
                    0 => &$class
                );
            }
        } else {
            print("Invalid function callback from Class ".get_class($class));
            return false;
        }

        return true;
    }

    /**
     * Do the callbacks to the other classes with the included data
     * @param $function String function name
     * @param $data array data
     */
    public function doCallBacks($function, $data)
    {
        if(isset($this->callbacks[$function])) {
            foreach ($this->callbacks[$function] as &$value) {
                call_user_func_array(array(&$value,$function), $data);
            }
        }
    }

    /**
     * Add a callback function for this class
     * @param string $function String function name
     */
    public function addCallBack(string $function)
    {
        $this->functionCallbacks[] = $function;
    }
}