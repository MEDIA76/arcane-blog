<?php

$posts = array_map(function($post) {
  $post = [
    'path' => $post,
    'slug' => basename($post, '.md')
  ];

  if(strpos($post['slug'], '-', 8) == 10) {
    $regex = "/^(\d{4}-\d{2}-\d{2})-(.+)$/";

    if(preg_match($regex, $post['slug'], $basename)) {
      $post['created'] = strtotime($basename[1]);
      $post['slug'] = $basename[2];
    }
  }

  return array_merge([
    'created' => filectime($post['path']),
    'modified' => filemtime($post['path'])
  ], $post);
}, glob(path(['PAGES', 'posts/*.md'], true)));

usort($posts, function($a, $b) {
  return $b['created'] - $a['created'];
});

return array_filter(array_merge([0], $posts));

?>