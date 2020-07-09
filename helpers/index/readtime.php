<?php

/**
 * Read Time 20.06.1 Arcane Helper
 * MIT https://helpers.arcane.dev
**/

return function($content, $wpm = 250, $suffix = 'min read') {
  if(strpos($content, "\n") === false) {
    if(preg_match('/^[^\s]+\.+[^\s]*[^\s\.]+$/', $content)) {
      if(is_file($path = path($content, true))) {
        $content = file_get_contents($path);
      }
    }
  }

  $time = ceil(str_word_count($content) / $wpm);

  return "{$time} {$suffix}";
};

?>