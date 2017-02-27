<?php

namespace App\Lib;

use App\Lib\SerializableObjectInterface;

interface RabbitSendInterface
{
    function __construct($queueName);

    /**
     * @param $objects
     * @return SerializableObjectInterface[]
     */
    function sendObjects($objects);
}