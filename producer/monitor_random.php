<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 10/8/15
 * Time: 11:17
 */

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$generator = (count($argv) >= 2) ? $argv[1]:"default";

require_once(__DIR__.'/examples/'.$generator.'.php');

/*** Rabbit setting up **/
$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('mike_monitor', 'topic', false, false, false);
while(true) {
    $wait = 0;
    $data = generate_message($wait);
    $msg = new AMQPMessage(json_encode($data));

    $routing_key = $data['body']['routing_key'];

    $channel->basic_publish($msg, 'mike_monitor', $routing_key);

    echo " [x] Sent ",$routing_key,':',json_encode($data)," \n";
    sleep($wait);
}

$channel->close();
$connection->close();
