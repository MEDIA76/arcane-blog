<?php

$posts = array_map(function($post) {
  $array['slug'] = basename($post, '.md');

  if(strpos($array['slug'], '-', 8) == 10) {
    $regex = "/^(\d{4}-\d{2}-\d{2})-(.+)$/";

    if(preg_match($regex, $array['slug'], $basename)) {
      $array['created'] = strtotime($basename[1]);
      $array['slug'] = $basename[2];
    }
  }

  return array_merge([
    'created' => filectime($post),
    'modified' => filemtime($post),
    'path' => path($post, true)
  ], $array);
}, glob('pages/posts/*.md'));

usort($posts, function($a, $b) {
  return $b['created'] - $a['created'];
});

return array_filter(array_merge([0], $posts));

?>