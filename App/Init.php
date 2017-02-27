<?php

namespace App;

$loader = require_once __DIR__ . '/../vendor/autoload.php';

use App\Lib\Config;
use App\Lib\Main;
use App\Lib\Worker;
use App\Lib\RabbitMainReceiver;
use App\Lib\RabbitMainSender;

/**
 * This class is the Init/config class for a demonstration
 * of using RabbitMq for parallel processing in PHP
 *
 * Class Init
 * @package app
 */
class Init
{

    /**
     * Keeps a tally of the process Ids under which the workers are running
     * @var array
     */
    public $pids = [];



    /**
     * Initialise the queues
     * Initialise the workers
     * Run the app
     */
    public function init()
    {
        $this->clearRabbitQueues();
        $this->startWorkers();
        $this->runMain();
        $this->stopWorkers();
    }

    /**
     * The workers might be started by a separate process
     * e.g. Jenkins
     */
    protected function startWorkers()
    {
        $numberOfWorkers = Config::NUMBER_OF_WORKERS;
        for($i=0; $i < $numberOfWorkers; $i++) {
            $this->pids[] = exec('php ./Lib/Worker.php > /dev/null & echo $!');
        }
    }

    /**
     * Stop the workers
     */
    public function stopWorkers()
    {
        foreach ($this->pids as $pid) {
            exec('sudo kill 9 '.$pid);
        }
    }

    /**
     * Clear the queues by starting and stopping Rabbit
     */
    public function clearRabbitQueues()
    {

        // stop rabbit, hide errors
        exec('sudo rabbitmqctl stop_app &2> /dev/null');

        // start rabbit
        exec('sudo rabbitmqctl start_app');

    }

    public function runMain()
    {
        $rabbitSender = new RabbitMainSender(CONFIG::QUEUE_NAME_MAIN_OUTWARD);
        $rabbitReceiver = new RabbitMainReceiver(CONFIG::QUEUE_NAME_MAIN_INWARD);
        $main = new Main($rabbitSender, $rabbitReceiver);
        $main->run();
    }

}

$init = new Init();
$init->init();