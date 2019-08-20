<?php

$posts = glob('pages/posts/*.md');

usort($posts, function($a, $b) {
  return filemtime($b) - filemtime($a);
});

return array_combine(array_map(function($post) {
  return basename($post, '.md');
}, $posts), $posts);

?>