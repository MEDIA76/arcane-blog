<?php

$posts = glob('pages/posts/*.md');

usort($posts, function($a, $b) {
  return filemtime($b) - filemtime($a);
});

return array_filter(array_merge([0], array_map(function($post) {
  $array['content'] = file_get_contents($post);

  return array_merge($array, [
    'slug' => basename($post, '.md'),
    'head' => strtok($array['content'], "\n"),
    'modified' => filemtime($post)
  ]);
}, $posts)));

?>