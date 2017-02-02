<?php

class Micropub {

  public static $endpoint;

  public static function setEndpoint($url, $token) {
    static::$endpoint = ['url' => $url, 'token' => $token];
  }

  public static function getEndpoint() {
    return static::$endpoint;
  }

  public static function post($data, $endpoint = null) {

    if($endpoint === null) $endpoint = static::getEndpoint();

    if(!isset($endpoint)
    or !isset($endpoint['url'])
    or !v::url($endpoint['url'])
    or !isset($endpoint['token'])) {
      throw new Exception('Invalid endpoint or no endpoint set. (Use micropub::setEndpoint($url, $token))', 1);
    }

    $defaults = [
      'h' => 'entry',
    ];

    $data = array_merge($data, $defaults);
    $data['access_token'] = $endpoint['token'];

    $r = remote::post($endpoint['url'], ['data' => $data]);

    if (($r->code == 201 or $r->code == 202)
    and array_key_exists('Location', $r->headers))
      return $r->headers['Location'];

    return false;
  }

  public static function note($content) {
    return static::post([
      'content' => $content,
    ]);
  }

  public static function like($url) {
    return static::post([
      'like-of' => $url,
    ]);
  }

  public static function bookmark($url) {
    return static::post([
      'bookmark-of' => $url,
    ]);
  }

  public static function reply($url, $content) {
    return static::post([
      'in-reply-to' => $url,
      'content' => $content,
    ]);
  }

  public static function rsvp($url, $value = 'yes', $content = null) {
    $data = [
      'in-reply-to' => $url,
      'rsvp' => $value,
    ];
    if($content) $data['content'] = $content;
    return static::post($data);
  }
}
