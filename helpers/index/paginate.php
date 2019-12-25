<?php

/**
 * Paginate 19.12.1 Arcane Helper
 * Copyright 2017-2019 Joshua Britt
 * MIT https://helpers.arcane.dev
**/

return function($array, $size = 10) {
  $array = array_chunk($array, $size, true);

  return array_filter(array_merge([0], $array));
}

?>