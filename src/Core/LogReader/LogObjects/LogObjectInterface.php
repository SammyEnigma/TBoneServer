<?php
namespace Core\LogReader\LogObjects;

interface LogObjectInterface
{
    /**
     * Return server time
     * @return int
     */
    public function getTime();
}