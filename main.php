<?php

    require_once('loader.php');
    
    $events = Lib\Manager::getInstance()->getObject('events');
    
    for ($i = 0; $i < 10000; $i++) {
        $user_id = rand(1,1000);
        $blocks = rand(1,5);
        for ($k = 0; $k < $blocks; $k++) {
            $events->addEvent($user_id, json_encode([
                'user_id' => 10,
                'message' => 'test'
            ]));            
        }
    }

?>
