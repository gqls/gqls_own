<?php


namespace App\Lib;


interface RabbitReceiveInterface
{
    function __construct($queueName);
    function receiveDataFromRabbitQueue();
}