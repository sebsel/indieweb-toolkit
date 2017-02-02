<?php

try {
  toolkit::version();
} catch (Error $e) {
  exit("Error: indieweb-toolkit requires getkirby/toolkit to work.");
}

require_once "indieweb-toolkit.php";