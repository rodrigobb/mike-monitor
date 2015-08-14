<?php

function generate_message(&$wait = null, $params = array('serialize' => false), $input = null) {

  if (is_array($params) && array_key_exists('url', $params)) {
    $url = $params['url'];
  } else {
    $url = 'http://www.google.com';
  }

  $ping = ping_url($url);

  $data = array(
      'socket_id' => 'push_notification',
      'body' => array(
          'routing_key'   => 'monitor.ping.'.$ping['http_response_code'],
          'code'          => $ping['http_response_code'],
          'timestamp'     => time(),
          'ping'          => $ping['time'],
      )
  );

  if (is_array($params) && array_key_exists('serialize', $params) && $params['serialize']) {
      $data = json_encode($data);
  }

  $wait = 1;
  return $data;
}

function ping_url($url=NULL)
{
    if($url == NULL) return false;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $response_time = curl_getinfo($ch, CURLINFO_CONNECT_TIME) * 1000;
    curl_close($ch);

    return array('time' => $response_time, 'http_response_code' => $httpcode);
}
