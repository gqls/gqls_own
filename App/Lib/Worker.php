<?php


namespace App\Lib;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Config;
use App\Lib\DataObject;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Exception;


class Worker
{
    // receive
    // send
    /**
     * @var RabbitSender
     */
    protected $rabbitSender;
    /**
     * @var RabbitReceiver
     */
    protected $rabbitReceiver;

    /**
     * @var string serialized object
     */
    protected $rawMessage;

    public $queueNameMainIn = Config::QUEUE_NAME_MAIN_INWARD;
    public $queueNameMainOut = Config::QUEUE_NAME_MAIN_OUTWARD;

    public function __construct()
    {
/*        $this->rabbitSender = $rabbitSender;
        $this->rabbitReceiver = $rabbitReceiver;*/
    }

    /**
     * Entry point for this class
     * see this file underneath this class
     */
    public function work()
    {
        $this->collectAndSendMessage();
    }

    /**
     * Collect a message from the Rabbit queue
     * unserialize it, transform it in some way
     * and return it again serialized
     *
     * This is a busy function but it is just an example
     */
    protected function collectAndSendMessage()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($this->queueNameMainOut, false, false, false, false);

        echo ' [*Worker] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg) {
            echo " [worker] Received ", $msg->body, "\n";
            $serializedChangedMessage = $this->processMessage($msg->body);
            $this->sendMessage($serializedChangedMessage);
        };

        $channel->basic_consume($this->queueNameMainOut, '', false, true, false, false, $callback);

        while(count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }

    /**
     * Unserializes the object from the message
     * changes it
     * sends back a serialized version
     *
     * @param $serializedMessage
     * @return string
     * @throws Exception
     */
    protected function processMessage($serializedMessage)
    {
        // unseriallize - change content - waste some process time
        $unserializedObject = DataObject::unserializeObject($serializedMessage);
        $changed = [];
        if ($unserializedObject instanceof DataObject) {
            $data = $unserializedObject->getData();
            foreach ($data as $key => $piece) {
                $changed[$key] = 'I am changed to this';
            }
            $unserializedObject->setData($changed);
        } else {
            throw new Exception('Unserializing the object in the worker caused a problem');
        }

        $serializedAgain = $unserializedObject->serializeObject();
        return $serializedAgain;
    }

    /**
     * @param $serializedMessage
     */
    protected function sendMessage($serializedMessage)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($this->queueNameMainIn, false, false, false, false);
        $msg = new AMQPMessage($serializedMessage);
        $channel->basic_publish($msg, '', $this->queueNameMainIn);
        echo " [Worker] Sent serialized message $serializedMessage \n";
        $channel->close();
        $connection->close();
    }
}

$worker = new Worker;
$worker->work();