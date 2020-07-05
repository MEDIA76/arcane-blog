<?php

return function($post) {
  $post['content'] = file_get_contents($post['path']);
  $token = strtok($post['content'], "\n");

  foreach(['heading', 'preview'] as $type) {
    if($type == 'heading') {
      if(substr(ltrim($token), 0, 1) !== '#') {
        continue;
      }
    } else if(array_key_exists('heading', $post)) {
      $token = strtok("\n");
    }

    $post[$type] = $token;
  }

  return $post;
};

?>