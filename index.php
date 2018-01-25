#!/usr/local/bin/php -q
<?php

namespace Program1;

//error_reporting(E_ALL);
//set_time_limit(0);

use BracketsParser\BracketsParser;
use Program1\Classes\SocketServer;

//use Program1\Classes\Content;

$pid = pcntl_fork();

if ($pid == 0) {
    require_once __DIR__ . "/vendor/autoload.php";
    //$filename = __DIR__ . "/data/data.txt";

    $task = function ($string) {
        return (BracketsParser::run($string/*Content::get($filename)*/) === true ? '' : 'In')
            . "Valid string\n";

    };
    (new SocketServer('127.0.0.1'))
        ->port('fromCommandLine')
        ->startAndWait($task);
    exit(1);
}

