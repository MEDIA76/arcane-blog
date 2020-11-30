<?php

/**
 * Truncate 20.03.1 Arcane Helper
 * MIT https://helpers.arcane.dev
**/

if(!function_exists('mb_strlen')) {
  function mb_strlen($str) {
    return strlen($str);
  }
}

if(!function_exists('mb_substr')) {
  function mb_substr($str, $start, $length = null) {
    return substr($str, $start, $length);
  }
}

return function($string, $limit = 100, $suffix = '...') {
  if(mb_strlen($string) <= $limit) {
    return $string;
  } else {
    return rtrim(mb_substr($string, 0, $limit)) . $suffix;
  }
};

?>