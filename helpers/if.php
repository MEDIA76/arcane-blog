<?php

/**
 * If 20.06.1 Arcane Helper
 * MIT https://helpers.arcane.dev
**/

return function($conditional, $return = null, $format = "\x20%s") {
  $passed = func_num_args();

  if($conditional) {
    if(strpos($format, '%s') === false) {
      $format = "\x20{$format}=\"%s\"";
    }

    return sprintf($format, $passed > 1 ? $return : $conditional);
  }
};

?>