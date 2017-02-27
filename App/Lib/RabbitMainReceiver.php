<?php


namespace App\Lib;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Exception;

class RabbitMainReceiver implements RabbitReceiveInterface
{
    /**
     * Name of rabbit queue to send and receive serialized objects
     *
     * @var
     */
    protected $queueName;

    /**
     * How many items were sent so they can be counted back in
     *
     * @var
     */
    protected $countOfOutgoingItems;

    /**
     * How many items have we received back from Rabbit
     *
     * @var
     */
    protected $countOfIncomingItems;

    /**
     * Rabbit connection object
     *
     * @var
     */
    protected $connection;

    /**
     * Rabbit channel - connection to particular queue
     * @var
     */
    protected $channel;

    /**
     * @var SerializableObjectInterface[]
     */
    protected $messages = [];

    /**
     * RabbitReceiver constructor.
     * Set queuename for receipt of serialized objects
     *
     * @param $queueName
     */
    public function __construct($queueName)
    {
        $this->queueName = $queueName;
        $this->connection = $this->makeConnection();
    }

    /*
     * Set the count of the number of items that were sent
     * so it can all be counted back in again
     */
    public function setCount($countOfOutgoingItems)
    {
        $this->countOfOutgoingItems = $countOfOutgoingItems;
    }

    /**
     * @param $serializedObject
     */
    public function receiveDataFromRabbitQueue()
    {

        $this->countOfIncomingItems = 0;

echo ' [main receiver] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg) {
            $message = unserialize($msg->body);
            $this->messages[] = $message;
            $this->countOfIncomingItems++;

var_dump('Count of outgoing: '. $this->countOfOutgoingItems. '. Count of incoming: '. $this->countOfIncomingItems);

            if ($this->countOfOutgoingItems <= $this->countOfIncomingItems) {

echo 'Count is enough, returning messages'."\n";
                $this->channel->callbacks = null;

            }
        };

        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        $this->channel->close();

        return $this->messages;

    }


    public function returnDataArray()
    {
        $receivedUnserializedData = $this->receiveDataFromRabbitQueue();
        return $receivedUnserializedData;
    }

    public function makeConnection()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queueName, false, false, false, false);
    }


}