<?php

namespace Lib;

class Manager {

    private static $instance = NULL;
    private $objects = [];

    private function __construct() {}
    private function __clone() {}

    public function setObject(&$object, $object_name) {
        $this->objects[$object_name] = $object;
        return $this;
    }
    
    public function getObject($object_name) {
        return isset($this->objects[$object_name])
            ? $this->objects[$object_name] : null;
    }

    public static function getInstance() {

        if(self::$instance == NULL) {
            self::$instance = new self;
        }

        return self::$instance;

    }

}
