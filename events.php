<?php

namespace Lib;

class Events {

    function addEvent($user_id, $message) {
    
        $redis = \Lib\Manager::getInstance()
            ->getObject('redis');
        $rabbit = \Lib\Manager::getInstance()
            ->getObject('rabbit');    
        
        $rabbit->addToQueue('queue', $message);
        $redis->push("user_".$user_id, $message);
        
        $rest = $redis->getFirst("user_".$user_id);
        if (empty($rest)) {
            $rabbit->addToQueue('queue', $message);
        }
    
    }
    
    public function check($user_id) {
    
        $redis = \Lib\Manager::getInstance()
            ->getObject('redis');
        $rabbit = \Lib\Manager::getInstance()
            ->getObject('rabbit');    
    
        $redis->pop("user_".$user_id);
        $rest = $redis->getFirst("user_".$user_id);
        if (!empty($rest)) {
            $rabbit->addToQueue('queue', $rest);
        }
    
    }

}

?>
