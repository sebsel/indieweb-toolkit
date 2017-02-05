<?php

// Load composer dependencies if available (only needed for SiloAPI)
if(f::exists($f =__DIR__ . DS . 'vendor' . DS . 'autoload.php')) require $f;


load([
  'mf2'        => __DIR__ . DS . 'lib' . DS .'mf2.php',
  'micropub'   => __DIR__ . DS . 'lib' . DS .'micropub.php',
  'webmention' => __DIR__ . DS . 'lib' . DS .'webmention.php',
  'indieauth'  => __DIR__ . DS . 'lib' . DS .'indieauth.php',
  'endpoint'   => __DIR__ . DS . 'lib' . DS .'endpoint.php',
  'siloapi'    => __DIR__ . DS . 'lib' . DS .'siloapi.php',
]);