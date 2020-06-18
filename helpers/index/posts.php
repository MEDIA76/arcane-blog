<?php

$posts = glob('pages/posts/*.md');

usort($posts, function($a, $b) {
  return filemtime($b) - filemtime($a);
});

return array_filter(array_merge([0], array_map(function($post) {
  $array['content'] = file_get_contents($post);
  $token = strtok($array['content'], "\n");

  foreach(['title', 'preview'] as $type) {
    if($type == 'title') {
      if(substr(ltrim($token), 0, 1) !== '#') {
        continue;
      }
    } else if(array_key_exists('title', $array)) {
      $token = strtok("\n");
    }

    $array[$type] = $token;
  }

  return array_merge($array, [
    'slug' => basename($post, '.md'),
    'modified' => filemtime($post)
  ]);
}, $posts)));

?>