<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 12/8/15
 * Time: 20:55
 */

/*
 * To receive all the logs:
 *      $ php console_log.php "#"
 *
 * To receive all logs from the source "kern":
 *      $ php console_log.php "kern.*.*"
 *
 * Or if you want to hear only about "error" logs:
 *      $ php console_log.php "*.*.error"
 *
 * You can create multiple bindings:
 *      $ php console_log.php "kern.*.*" "*.*.error"
 */

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('mike_monitor', 'topic', false, false, false);
list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

$binding_keys = array_slice($argv, 1);
if( empty($binding_keys )) {
    file_put_contents('php://stderr', "Usage: $argv[0] [binding_key]\n");
    exit(1);
}

foreach($binding_keys as $binding_key) {
    $channel->queue_bind($queue_name, 'mike_monitor', $binding_key);
}
echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";
$callback = function($msg){
    echo ' [x] ',$msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
