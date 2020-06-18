<?php

/**
 * If 19.12.1 Arcane Helper
 * MIT https://helpers.arcane.dev
**/

return function($content, $reference, $target = null) {
  if(!is_null($target)) {
    $target = "\x20target=\"{$target}\"";
  }

  return "<a href=\"{$reference}\"{$target}>{$content}</a>";
};

?>