<?php


// https://www.rabbitmq.com/tutorials/tutorial-one-php.html
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Receiver
{
    protected $messages = [];
    protected $channel;
    protected $connection;
    protected $count;

    public function run()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('hello', false, false, false, false);

        $this->count = 5;


        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback = function ($msg) {
            echo " [x] Received ", $msg->body, "\n";

            $this->messages[] = $msg->body;
            var_dump('Inside callback, count of inward messages:', count($this->messages));

            if (count($this->messages) >= $this->count)
            {
                echo 'Count is enough, returning messages'."\n";
                //var_dump('$this->channel->callbacks', $this->channel->callbacks);
                $this->channel->callbacks = null;
            }
        };
        $this->channel->basic_consume('hello', '', false, true, false, false, $callback);
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();

        return $this->messages;
    }

}

$receive = new Receiver();
print_r($receive->run());