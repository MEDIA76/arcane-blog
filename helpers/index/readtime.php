<?php

return function($content, $wpm = 250, $suffix = 'min read') {
  $time = ceil(str_word_count($content) / $wpm);

  return "$time $suffix";
};

?>