<?php

function generate_message(&$wait = null, $params = array('serialize' => false), $input = null) {
  $source = 'monitor';

  $fixtures = array(
    'section' => array('ping', 'homepage'),
    'level'   => array('info', 'warn', 'error'),
  );

  $cost = rand(0,5);
  $level = rand(0,2);
  $routing_key = $source.'.'.$fixtures['section'][rand(0,1)].'.'.$fixtures['level'][$level];

  $data = array(
      'socket_id' => 'push_notification',
      'body' => array(
          'routing_key'   => $routing_key,
          'level'         => $fixtures['level'][$level],
          'timestamp'     => time(),
          'total'         => $cost * 100.0,
          'minutes'       => rand(0, 60),
          'seconds'       => rand(0, 60),
      )
  );

  if (is_array($params) && array_key_exists('serialize', $params) && $params['serialize']) {
      $data = json_encode($data);
  }

  $wait = $cost;
  return $data;
}
