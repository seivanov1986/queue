<?php

define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT', '6379');

define('RABBITMQ_HOST', '127.0.0.1');
define('RABBITMQ_PORT', '1000');
define('RABBITMQ_USER', 'user_1');
define('RABBITMQ_PASS', 'passwd');

require_once('redis.php');
require_once('rabbit.php');
require_once('events.php');
require_once('manager.php');

\Lib\Manager::getInstance()
    ->setObject(new \Lib\Redis(10), 'redis')
    ->setObject(new \Lib\Events(), 'events')
    ->setObject(new \Lib\RabbitMQ(), 'rabbit');
