<?php


namespace src\Core\Commands;


abstract class BaseCommand
{
    private $teamchat = false;
    private $cmds = array();
    private $help;
    private $usage;
    private $args;
}