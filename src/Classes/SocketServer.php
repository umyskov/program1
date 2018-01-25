<?php

namespace Program1\Classes;

use Program1\Exceptions\InvalidArgumentException;

class SocketServer
{
    public function __construct($server)
    {
        $this->server = $server;
    }

    public function port($port)
    {
        try {
            if ($port == 'fromCommandLine' &&
                (
                    empty($options = getopt('p:'))
                    || ($port = $options['p']) === false
                    || !is_numeric($port)
                )
            ){
                throw new InvalidArgumentException("Invalid port");
            }
            $this->port = $port;
            return $this;

        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            exit(1);
        }
    }

    public function startAndWait($task)
    {
        ob_implicit_flush();

        $address = $this->server;
        $port = $this->port;

        if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }

        if (socket_bind($sock, $address, $port) === false) {
            echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        }

        if (socket_listen($sock, 5) === false) {
            echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        }

        do {

            if (($msgsock = socket_accept($sock)) === false) {
                echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
                break;

            } else {
                $pid = pcntl_fork();
            }

            if ($pid == 0) {
                /* Send instructions. */
                $msg = "\nWelcome to the PHP Test Server. \n" .
                    "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
                socket_write($msgsock, $msg, strlen($msg));

                do {
                    if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
                        echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
                        break 2;
                    }

                    if (!$buf = trim($buf)) {
                        continue;
                    }

                    if ($buf == 'quit') {
                        break;
                    }

                    if ($buf == 'shutdown') {
                        socket_close($msgsock);
                        break 2;
                    }

                    $response = $task($buf);
                    socket_write($msgsock, $response, strlen($response));
                } while (true);
                socket_close($msgsock);

                exit(1);
            }

        } while (true);
        socket_close($sock);
    }
}

