<?php

namespace Lib;

class Redis
{

    var $redis = null;
    var $connection = null;
    var $db_name = null;

    public function __construct ($db_name = '') {
    
        try {
            if (!class_exists('\Redis')) {
                throw new \Exception('Redis Class does not exists');
            }
            $this->redis = new \Redis();
            $this->connection = $this->redis->connect(REDIS_HOST, REDIS_PORT, 2);
            if ($this->connection) {
                $this->db_name = empty($db_name) === false ? $db_name : 1;
                $this->redis->select($this->db_name);
            } else {
                throw new \Exception('Redis connection error');
            }
        }
        catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
        
    }
    
    public function push ($queue_name, $message) {
        $this->redis->lPush($queue_name, $message);
    }
    
    public function getFirst($queue_name) {
        return $this->redis->lrange($queue_name, 0, 0);
    }
    
    public function pop ($queue_name) {
        return $this->redis->rpoprpush($queue_name);
    }

    function __destruct() {

    }
    
}
