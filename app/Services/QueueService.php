<?php

namespace App\Services;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class QueueService
{
    public static function sendToQueue($payload)
    {
        $host = 'fox.rmq.cloudamqp.com';
        $port = 5672;
        $user = 'yhjkpejo';
        $pass = 'urWWzjnVTAK5DQGYbCYTvacnZz03i3Q5';
        $vhost = 'yhjkpejo';
        $queue = 'mainqueue';

        $connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
        $channel = $connection->channel();

        $channel->queue_declare($queue, false, false, false, false);

        $msg = new AMQPMessage($payload);
        $channel->basic_publish($msg, '', $queue);

        $channel->close();
        $connection->close();
    }

}
