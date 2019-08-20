<?php

define('ROUTE', [
  ['post', array_keys($posts)]
]);

if(path(1) == 'post') {
  $posts = array_filter($posts, function($post) {
    return $post == path(2);
  }, ARRAY_FILTER_USE_KEY);
}

?>

<?php foreach($posts as $slug => $post) { ?>
  <article>
      <time><?= date('M j, Y', filemtime($post)); ?></time>
      <?php if(!path(1)) { ?>
        <?= $markdown($truncate(file_get_contents($post), 200, '... <a href="' . path("/post/{$slug}/") . '">continue</a>')); ?>
      <?php } else { ?>
        <?= $markdown($post); ?>
      <?php } ?>
  </article>
<?php } ?>