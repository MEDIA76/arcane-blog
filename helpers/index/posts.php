<?php

$posts = glob('pages/posts/*.md');

usort($posts, function($a, $b) {
  return filemtime($b) - filemtime($a);
});

return array_column(array_map(function($post) {
  return [
    'slug' => basename($post, '.md'),
    'content' => file_get_contents($post),
    'modified' => filemtime($post)
  ];
}, $posts), null, 'slug');

?>