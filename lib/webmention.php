<?php

class Webmention {

  /**
   * Parse Microformats2 from a HTML string
   *
   * @param string $url The url of the page you want to discover the endpoint for
   * @return string the URL of the Endpoint or false if not found
   */
  public static function discoverEndpoint($url) {

    $response = remote::get($url);
    $url      = $response->info['url'];
    $html     = $response->content();
    $headers  = $response->headers();

    $headers = array_change_key_case($headers);

    if(isset($headers['link'])) {
      foreach(explode(',', $headers['link']) as $link) {
        if(!preg_match('!\<(.*?)\>;\s*rel="?(.*?\s)?webmention(\s.*?)?"?!', $link, $match)) continue;

        $endpoint = url::makeAbsolute($match[1], $url);

        // return valid endpoint or continue searching
        if(v::url($endpoint)) return $endpoint;
      }
    }

    // You can't parse HTML with regex
    if(preg_match_all('!\<(a|link)(.*?)\>!i', $html, $links)) {
      foreach($links[0] as $link) {
        if(!preg_match('!\srel\s*=\s*["\'](.*?\s)?webmention(\s.*?)?["\']!', $link)) continue;
        if(!preg_match('!\shref\s*=\s*["\'](.*?)["\']!', $link, $match)) continue;

        $endpoint = url::makeAbsolute($match[1], $url);

        // return valid endpoint
        if(v::url($endpoint)) return $endpoint;
      }
    }

    return false;
  }
}
