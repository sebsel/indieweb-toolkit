<?php

class Endpoint {

  public static function micropub($options) {

    // No auth yet, don't use this :D
    IndieAuth::requireMe();
    IndieAuth::requireScope('post');

    if(r::is('GET')) {
      echo response::error('?q=config is a TODO', 501);
      return false;
    }

    if(r::is('POST') and $data = r::postData() and isset($data['h'])) {

      // What is the type?
      $type = $data['h'];
      unset($data['h']);

      // Was there a slug?
      if(isset($data['mp-slug'])) $slug = $data['mp-slug'];
      else $slug = false;
      unset($data['mp-slug']);

      // Call the 'create' callback
      try {

        if(isset($options['create']) and is_callable($options['create'])) {

          $url = call($options['create'], [$type, $data, $slug]);

          if($url) {
            header::redirect($url, 201);
            return $url;
          }

          throw new Error('The \'create\' callback did not return a URL');

        } else throw new Error('No \'create\' callback defined');

      } catch(Error $e) {
        echo response::error($e->getMessage(), 500);
        return false;
      }

    } else {
      echo response::error('Send a h= in your POST request', 400);
      return false;
    }
  }
}
