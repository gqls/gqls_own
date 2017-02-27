Installation:

sudo apt install php-mbstring php-bcmath
sudo apt install rabbitmq-server

install composer

composer.json something like:
{
    "require-dev": {
        "phpunit/phpunit": "^6.0"
    },
    "require": {
        "php-amqplib/php-amqplib": "^2.6",
        "phpdocumentor/reflection-docblock": "2.0.4",
	    "phpdocumentor/phpdocumentor":"2.9"
    }
}

composer update

install htop
sudo apt install htop
you need your vm to be using more than one core
lscpu will tell you how many cores your virtualbox is using

useful commands for rabbitmq:

start the server
sudo rabbitmqctl start_app

restart the server
sudo rabbitmqctl stop_app
sudo rabbitmqctl start_app

look at the queues
sudo rabbitmqctl list_queues
or
sudo watch rabbitmqctl list_queues
then Ctl-C to get out of it

test server is running using ->
php Sender.php
then sudo watch rabbitmqctl list_queues in another terminal
and then php Receiver.php


This is a cool link that explains a lot of the parallel processing trickery
https://medium.com/async-php/multi-process-php-94a4e5a4be05#.1b8cgpbws

Use ps -o pid,%cpu,%mem,state,start -p [process number]
or htop to view processes
