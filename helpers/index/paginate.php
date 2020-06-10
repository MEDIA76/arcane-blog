<?php

/**
 * Paginate 19.12.1 Arcane Helper
 * MIT https://helpers.arcane.dev
**/

return function($array, $size = 10) {
  $array = array_chunk($array, $size, true);

  return array_filter(array_merge([0], $array));
}

?>