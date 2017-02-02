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
        if(preg_match('!\<(.*?)\>;\s*rel="?(.*?\s)?webmention(\s.*?)?"?!', $link, $match)) {

          $endpoint = url::makeAbsolute($match[1], $url);

          // return valid endpoint or continue searching
          if(v::url($endpoint)) return $endpoint;
        }
      }
    }

    if(preg_match_all('!\<(a|link)(.*?)\>!i', $html, $links)) {

      foreach($links[0] as $link) {

        if(!preg_match('!rel="(.*?\s)?webmention(\s.*?)?"!', $link)) continue;
        if(!preg_match('!href="(.*?)"!', $link, $match)) continue;
        if($match[1] == "") return $url;

        $endpoint = url::makeAbsolute($match[1], $url);

        // invalid endpoint
        if(!v::url($endpoint)) continue;

        return $endpoint;
      }
    }

    return false;
  }
}
