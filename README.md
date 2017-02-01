Indieweb Toolkit
====

A Kirby Toolkit style toolkit for IndieWeb stuff.

## Overview

This toolkit is meant to be used next to the [Kirby Toolkit](http://github.com/getkirby/toolkit). This is also a dependency.

## Docs

### Mf2

A wrapper for the [php-mf2 Microformats2 parser](https://github.com/indieweb/php-mf2).

#### mf2::parse($html, $url = null)

To parse a HTML string. Returns Microformats2 as an associative array.

#### mf2::fetch($url)

Fetch Microformats from a URL. Returns Microformats2 as an associative array.

#### mf2::tojf2($mf2)

Flattens a Microformats2 array to the experimental jf2 format.

### Webmention

#### webmention::discoverEndpoint($url)

Discovers an endpoint of a URL.
* TODO: solve relative urls better (see https://github.com/getkirby/toolkit/pull/213)