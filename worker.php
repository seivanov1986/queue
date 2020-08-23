#!/usr/local/bin/php
<?php

require_once("loader.php");

$events = new \Lib\Manager->getInstance()
    ->getObject('events');    
$rabbit = new \Lib\Manager->getInstance()
    ->getObject('rabbit');    

$rabbit->getMessages('events_queue', function ($msg) use ($rabbit) {

    $obj = json_decode($msg->body);
    $user_id = $obj->user_id;

    sleep(1);
    file_put_contents("log.txt", time() . ' ' . $user_id . "\n");
    
    $events->check($user_id);   
    $rabbit->dropFromQueue($msg);

});
