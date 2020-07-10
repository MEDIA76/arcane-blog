<?php

$pages = path(['PAGES'], true);

return function($post) use($pages) {
  if(defined('LOCALE')) {
    $path = substr($post['path'], strlen($pages));
    $locale = path(['LOCALES', LOCALE['LANGUAGE']], true);

    if(is_file($path = "{$locale}{$path}")) {
      $post['path'] = $path;
    }
  }

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