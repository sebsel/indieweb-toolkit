# Indieweb Toolkit

A Kirby Toolkit style toolkit for IndieWeb stuff.

## Overview

This toolkit is meant to be used next to the [Kirby Toolkit](http://github.com/getkirby/toolkit). This is also a dependency.

# Docs

## Mf2

A wrapper for the [php-mf2 Microformats2 parser](https://github.com/indieweb/php-mf2).

- `mf2::parse($html, $url = null)`  
  To parse a HTML string. Returns Microformats2 as an associative array.

- `mf2::fetch($url)`  
  Fetch Microformats from a URL. Returns Microformats2 as an associative array.

- `mf2::tojf2($mf2)`  
  Flattens a Microformats2 array to the experimental jf2 format.

## Webmention

Do things with webmentions.

- `webmention::discoverEndpoint($url)`  
  Discovers an endpoint of a URL.
  
  TODO: solve relative urls better (see https://github.com/getkirby/toolkit/pull/213)

## Micropub

A helper class for Micropub requests

Usage:
```php
// Set URL and access token of the endpoint to use
micropub::setEndpoint('http://yoursite.com/micropub', 'xxx');

micropub::reply('http://example.com/a-nice-post', "Oh what a post!");
micropub::like('http://example.com/another-post');
micropub::rsvp('http://example.com/an-event', 'maybe');

$newURL = micropub::post([
  'name' => 'Custom posts are possible!',
  'content' => 'This is a story about (...)',
  'category' => ['story', 'custom'],
  'mp-slug' => 'custom-posts-are-possible',
  'mp-syndicate-to' => 'https://twitter.com/example',
]);

go($newURL);
```

- `micropub::like($url)`  
  Like a post
  
- `micropub::reply($url, $message)`  
  Reply to a post
  
- `micropub::note($content)`  
  Create basic post

- `micropub::rsvp($url, $rsvp = 'yes', $message = null)`  
  RSVP 'yes' to an event, or set `$rsvp` and `$message` for custom RSVPs.
  
- `micropub::bookmark($url)`  
  Bookmark a post (sends `bookmark-of`)
  
- `micropub::post($data, $endpoint = null)`  
  Create your own Micropub request. With the second param you can set a custom endpoint as an array with `['endpoint' => 'http://example.com/micropub', 'token' => 'xxx']`.
  
- `micropub::setEndpoint($url, $token)`  
  Set the endpoint to use.
  
- `micropub::getEndpoint()`  
  Returns the current endpoint array.
