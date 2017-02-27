<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Sender
{

    public function run()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        $msg = new AMQPMessage('Hello W!');
        $channel->basic_publish($msg, '', 'hello');
        echo " [x] Sent 'Hello W!'\n";
        $channel->close();
        $connection->close();
    }

}

$send = new Sender();
$send->run();