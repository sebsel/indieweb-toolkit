<?php

class SiloAPI {

  const ERROR_INVALID_ADAPTER = 0;

  public static $adapters = array();
  public static $tokens = array();
  public static $connections = array();

  public static function adapter($type) {

    if(isset(static::$adapters[$type])) return static::$adapters[$type];

    throw new Error('Invalid adapter type', static::ERROR_INVALID_ADAPTER);

  }

  public static function connect($type) {
    $adapter = static::adapter($type);
    return call_user_func($adapter['connect']);
  }

  public static function api($type, $resource) {
    $adapter = static::adapter($type);
    return call_user_func($adapter['api'], $resource);
  }

  public static function setToken($type, $token) {
    static::$tokens[$type] = $token;
  }

  public static function like($type, $url) {
    $adapter = static::adapter($type);
    return call_user_func($adapter['like'], $url);
  }
}

/**
 * Twitter adapter
 */
siloapi::$adapters['twitter'] = [
  'connect' => function() {
    return new Abraham\TwitterOAuth\TwitterOAuth(
      siloapi::$tokens['twitter']['consumer_key'],
      siloapi::$tokens['twitter']['consumer_secret'],
      siloapi::$tokens['twitter']['oauth_token'],
      siloapi::$tokens['twitter']['oauth_token_secret']);
  },
  'api' => function($resource) {
    $connection = siloapi::connect('twitter');
    $content = $connection->get($resource);

    return $content;
  },
  'like' => function($url) {
    $connection = siloapi::connect('twitter');
    $content = $connection->post('favorites/create', [
      'id' => a::last(explode('/', $url)),
    ]);

    return $content;
  },
];
