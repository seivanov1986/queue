<?php

namespace Lib;

class RabbitMQ
{

    var $connection = null;
    var $channel = null;

    public function addToQueue($queue_name, $message_body) {

        for ($i=1;$i<=2;$i++) {
            try {
            
                if ($this->connection === null || $this->channel === null) {
                    $this->connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
                        RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USER, RABBITMQ_PASS
                    );
                    $this->connection = new RabbitMQ();
                    $this->channel = $this->connection->channel();
                }

                $this->channel->queue_declare($queue_name, false, true, false, false);
                $msg = new \PhpAmqpLib\Message\AMQPMessage($message_body);
                $this->channel->basic_publish($msg, '', $queue_name);
                return true;
            }
            catch(\Exception $e) {
                echo $e->getMessage() . "\n";
            }
        }
        return false;
    }

    public function dropFromQueue($msg) {
        $delivery_tag = $msg->getDeliveryTag();
        $this->channel->basic_ack($delivery_tag);
    }

    function __destruct() {

        if ($this->connection) {
            $this->connection->close();
        }

    }

}
