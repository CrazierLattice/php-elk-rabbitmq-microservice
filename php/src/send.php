<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

try {
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('log_queue', false, true, false, false);

    $data = [
        'message' => 'Hello from PHP to RabbitMQ!',
        'timestamp' => date('Y-m-d H:i:s')
    ];
    $msg = new AMQPMessage(json_encode($data));

    $channel->basic_publish($msg, '', 'log_queue');

    echo " [x] Sent 'Hello from PHP to RabbitMQ!'\n";

    $channel->close();
    $connection->close();

    echo "<br/><a href='index.php'>Go back</a>";
} catch (Exception $e) {
    echo 'Message could not be sent. Error: ',  $e->getMessage(), "\n";
    echo "<br/><a href='index.php'>Go back</a>";
}
