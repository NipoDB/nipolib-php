<?php

namespace Nipo;

use Exception;
use \Nipo\Shell;

class Client {
    public static $port;
    public static $hostAddress;

    public function __construct(string $hostAddress = '127.0.0.1', int $port = 2323)
    {
        if(filter_var($hostAddress, FILTER_VALIDATE_IP, ['options' => ['default' => false,]]) === false)
            throw new Exception('unacceptable format for hostAddress parameter.'); // TODO: implement dedicated Exception instance for nipo library

        if(filter_var($port, FILTER_VALIDATE_INT,  ['options' => ['default' => false,]]) === false OR !($port >= 1 AND $port <= 65535)) // checking for standard port range
            throw new Exception('unacceptable format for port parameter.');

        self::$port = $port;
        self::$hostAddress = $hostAddress;

        Shell::checkServerAvailability($this);
    }

    public function print() { // dev env only
        var_dump(self::$port, self::$hostAddress);
    }
}