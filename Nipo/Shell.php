<?php

namespace Nipo;

use Nipo\Client;
use Exception;

class Shell {
    public static function checkServerAvailability(Client $client) {
        if(in_array($client::$hostAddress, ['', null]) OR in_array($client::$port, ['', null, 0]))
			throw new Exception('given nipo instance is not configured properly, missing port or host address values.');
			
		
		// check if the given port is available and listening or not
		$connection = fsockopen($client::$hostAddress, $client::$port);
		if(!is_resource($connection))
			throw new Exception("Refused connection " . $client::$hostAddress . ":" . $client::$port);
		else{
			fclose($connection);
			unset($connection);
		}

        // check if nipo server functions properly
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $result = socket_connect($socket, $client::$hostAddress, $client::$port);
        if ($result === false) {
            throw new Exception(socket_strerror(socket_last_error($socket)));
		}

        $command = "token ping\r\n";
        socket_write($socket, $command, strlen($command));
        $response = socket_read($socket, 2048);
        socket_close($socket);
        return $response === 'pong';
    }
}