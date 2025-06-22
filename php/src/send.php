<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

try {
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $exchangeName = 'logs_exchange';
    $channel->exchange_declare($exchangeName, 'topic', false, true, false);

    $logLevel = $_GET['level'] ?? 'info';
    $validLevels = ['info', 'warning', 'error'];
    if (!in_array($logLevel, $validLevels)) {
        $logLevel = 'info';
    }

    $data = [
        'message' => "This is a(n) {$logLevel} message from PHP!",
        'timestamp' => date('Y-m-d H:i:s')
    ];
    $msg = new AMQPMessage(json_encode($data));

    $channel->basic_publish($msg, $exchangeName, $logLevel);

    echo " [x] Sent '{$logLevel}' message.\n";

    $channel->close();
    $connection->close();

    echo "<br/><a href='index.php'>Go back</a>";
} catch (Exception $e) {
    echo 'Message could not be sent. Error: ',  $e->getMessage(), "\n";
    echo "<br/><a href='index.php'>Go back</a>";
}
