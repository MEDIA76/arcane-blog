<?php

/**
 * Truncate 19.08.1 Arcane Helper
 * Copyright 2017-2019 Joshua Britt
 * MIT https://helpers.arcane.dev
**/

return function($string, $limit = 100, $suffix = '...') {
  if(mb_strlen($string) <= $limit) {
    return $string;
  } else {
    return rtrim(mb_substr($string, 0, $limit)) . $suffix;
  }
};

?>