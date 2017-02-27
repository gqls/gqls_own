<?php
/**
 * Created by PhpStorm.
 * User: laravel
 * Date: 26/02/17
 * Time: 19:48
 */

namespace App\Lib;


class Config
{

    /**
     * How many workers we want to start up
     */
    const NUMBER_OF_WORKERS = 4;
    const QUEUE_NAME_MAIN_INWARD = 'random_object_process_main_queue_in';
    const QUEUE_NAME_MAIN_OUTWARD = 'random_object_process_main_queue_out';
}