<?php

define('ROUTES', [
  ['post', array_keys($posts)]
]);

if(path(1) == 'post') {
  $post = $posts[path(2)];
  $title = strtok($post['content'], "\n");

  relay('TITLE', strip_tags($markdown($title)));
}

?>

<?php if(isset($post)) { ?>
  <article>
    <time><?= date('M j, Y', $post['modified']); ?></time>
    <?= $markdown($post['content']); ?>
  </article>
<?php } else { ?>
  <?php foreach($posts as $post) { ?>
    <article>
      <time><?= date('M j, Y', $post['modified']); ?></time>
      <?php $continue = scribe('... <a href=":reference">continue</a>', [
        ':reference' => path("/post/{$post['slug']}/")
      ]); ?>
      <?= $markdown($truncate($post['content'], 200, $continue)); ?>
    </article>
  <?php } ?>
<?php } ?>