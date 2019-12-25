<?php

if(path(1) == 'post') {
  $posts = array_column($posts, null, 'slug');
  $post = $posts[path(2)];

  define('ROUTES', [
    ['post', array_keys($posts)]
  ]);

  relay('TITLE', strip_tags($markdown($post['head'])));
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
      <?php $continue = scribe('...&nbsp;<a href=":reference">continue</a>', [
        ':reference' => path("/post/{$post['slug']}/")
      ]); ?>
      <?= $markdown($truncate($post['content'], 200, $continue)); ?>
    </article>
  <?php } ?>
<?php } ?>