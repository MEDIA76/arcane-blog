<?php

/**
 * Truncate 19.05.1 Arcane Helper
 * https://github.com/MEDIA76/arcane-helpers
**/

return function($string, $limit = 100, $suffix = '...') {
  if(mb_strlen($string) <= $limit) {
    return $string;
  } else {
    return mb_substr(rtrim($string), 0, $limit) . $suffix;
  }
};

?>