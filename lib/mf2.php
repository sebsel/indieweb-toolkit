<?php

class Mf2 {

  /**
   * Parse Microformats2 from a HTML string
   *
   * @param string $html The HTML
   * @param string $url The url of the page, to solve relative urls in the document
   * @return array Microformats2 object
   */
  public static function parse($html, $url = null) {
    require_once dirname(__DIR__) . DS . 'vendor' . DS . 'mf2' . DS . 'mf2.php';
    return \Mf2\parse($html, $url);
  }

  /**
   * Finds a Microformats2 object of a certain type
   *
   * @param string $url The url to parse
   * @return array Microformats2 object
   */
  public static function fetch($url) {
    require_once dirname(__DIR__) . DS . 'vendor' . DS . 'mf2' . DS . 'mf2.php';
    return \Mf2\fetch($url);
  }

  # mf2 to jf2 converter
  # licence cc0
  #  2015 Kevin Marks (python)
  #  2016 Sebastiaan Andeweg (php)
  /**
   * Flattens the structure of a Microformats2 object
   *
   * @param array $mf2 A Microformats2 object
   * @return array the simplefied Jf2 object
   */
  public static function tojf2($mf2) {
    $items = isset($mf2['items']) ? $mf2['items'] : [];
    $jf2 = static::flattenProperties($items, true);
    return $jf2;
  }

  private static function flattenProperties($items, $isOuter = false) {
    if (is_array($items)) {
      if (count($items) < 1) return [];
      if (count($items) == 1) {
        $item = $items[0];
        if (is_array($item)) {
          if (key_exists('type', $item)) {
            $props = [
              'type' => isset($item['type'][0]) ? substr($item['type'][0],2) : ''
            ];

            $properties = isset($item['properties']) ? $item['properties'] : [];

            foreach ($properties as $k => $prop) {
              $props[$k] = static::flattenProperties($prop);
            }

            $children = isset($item['children']) ? $item['children'] : [];

            if ($children) {
              if (count($children) == 1) {
                $props['children'] = [static::flattenProperties($children)];

              } else {
                $props['children'] = static::flattenProperties($children);
              }
            }
            return $props;

          } elseif (key_exists('html', $item) and key_exists('value', $item)) {
            return ['html' => $item['html'], 'value' => $item['value']];
          } elseif (key_exists('value', $item)) {
            return $item['value'];
          } else {
            return '';
          }
        } else {
          return $item;
        }


      } elseif ($isOuter) {
        $children = [];
        foreach ($items as $child) {
          $children[] = static::flattenProperties([$child]);
        }
        return ["children" => $children];

      } else {
        $children = [];
        foreach ($items as $child) {
          $children[] = static::flattenProperties([$child]);
        }
        return $children;
      }
    } else {
      return $items; // not a list, so string
    }
  }
}
