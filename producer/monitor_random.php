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

/*
 * Fake possible values
 *
    array(
        'routing_key' => 'monitor.ping',
        'level'       => 'info',            // info, warn, error
        'timestamp'   => null,
        'total'         => $cost * 100.0,
        'minutes'       => rand(0, 60),
        'seconds'       => rand(0, 60),
    );
*/

$source = 'monitor';
$fixtures_section = array('ping', 'homepage');
$fixtures_level = array('info', 'warn', 'error');


/*** Rabbit setting up **/
$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('mike_monitor', 'topic', false, false, false);

while(true) {
    $cost = rand(0,5);
    $level = rand(0,2);
    $routing_key = $source.'.'.$fixtures_section[rand(0,1)].'.'.$fixtures_level[$level];

    $data = array(
        'socket_id' => 'push_notification',
        'body' => array(
            'routing_key'   => $routing_key,
            'level'         => $level,
            'timestamp'     => time(),
            'total'         => $cost * 100.0,
            'minutes'       => rand(0, 60),
            'seconds'       => rand(0, 60),
        )
    );

    $msg = new AMQPMessage(json_encode($data));

    $channel->basic_publish($msg, 'mike_monitor', $routing_key);
    echo " [x] Sent ",$routing_key,':',json_encode($data)," \n";
    sleep($cost);
}

$channel->close();
$connection->close();
