<?php

return function($post) {
  $post['content'] = file_get_contents($post['path']);
  $token = strtok($post['content'], "\n");

  foreach(['title', 'preview'] as $type) {
    if($type == 'title') {
      if(substr(ltrim($token), 0, 1) !== '#') {
        continue;
      }
    } else if(array_key_exists('title', $post)) {
      $token = strtok("\n");
    }

    $post[$type] = $token;
  }

  return $post;
};

?>