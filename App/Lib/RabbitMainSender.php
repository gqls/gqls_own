<?php


namespace App\Lib;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMainSender implements RabbitSendInterface
{
    /**
     * Queue name to use for rabbit queue
     * @var
     */
    protected $queueName;

    /**
     * Rabbit connection object
     *
     * @var AMQPStreamConnection
     */
    protected $connection;

    /**
     * Rabbit channel - connection to particular queue
     * @var
     */
    protected $channel;

    /**
     * RabbitSender constructor.
     * Set queueName for use when sending
     *
     * @param $queueName
     */
    public function __construct($queueName)
    {
        $this->queueName = $queueName;
        $this->makeConnection();
    }

    /**
     * Serialize and send object
     *
     * @param $objects
     */
    public function sendObjects($objects)
    {
        foreach ($objects as $object)
        {
            $serializedObject =  $object->serializeObject();
            $this->sendToRabbit($serializedObject);
        }

    }

    /**
     * @param $serializedObject
     */
    protected function sendToRabbit($serializedObject)
    {
        $msg = new AMQPMessage($serializedObject);
        $this->channel->basic_publish($msg, '', $this->queueName);
    }

    /**
     * Set up rabbit connection
     */
    protected function makeConnection()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queueName, false, false, false, false);
    }
}