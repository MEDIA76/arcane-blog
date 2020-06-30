<?php

$posts = glob('pages/posts/*.md');

usort($posts, function($a, $b) {
  return filemtime($b) - filemtime($a);
});

return array_filter(array_merge([0], array_map(function($post) {
  return [
    'path' => path($post, true),
    'modified' => filemtime($post),
    'slug' => basename($post, '.md')
  ];
}, $posts)));

?>