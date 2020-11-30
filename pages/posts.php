<?php

if(!is_numeric($page = path(2) ?? 1)) {
  $posts = array_column($entries, null, 'slug');
  $post = $content($posts[$page]);

  if(array_key_exists('heading', $post)) {
    relay('TITLE', trim(ltrim($post['heading'], '#')));
  }

  define('ROUTES', array_keys($posts));
} else {
  $pages = $paginate($entries, 1);
  $posts = array_map($content, $pages[$page]);

  define('ROUTES', array_keys($pages));
}

?>

<?php if(isset($post)) { ?>
  <article>
    <time>
      <span><?= date('M j, Y', $post['created']); ?></span>
      <span><?= $readtime($post['content']); ?></span>
    </time>
    <?= $markdown($post['content']); ?>
    <?php if($post['modified'] > $post['created']) { ?>
      <time><i><?= scribe('Last updated on :date', [
        ':date' => date('M j, Y', $post['modified'])
      ]) ?></i></time>
    <?php } ?>
  </article>
<?php } else { ?>
  <?php foreach($posts as $post) { ?>
    <article>
      <time>
        <span><?= date('M j, Y', $post['created']); ?></span>
        <span><?= $readtime($post['content']); ?></span>
      </time>
      <?php $link = path("/posts/{$post['slug']}/"); ?>
      <?php if(array_key_exists('heading', $post)) { ?>
        <?php $regex = "/^[\s]*(\#+)\s+(.+)$/"; ?>
        <?= $markdown([
          preg_replace($regex, "$1 [$2]({$link})", $post['heading'])
        ]); ?>
      <?php } ?>
      <p><?= implode('&nbsp;', [
        $truncate(strip_tags($markdown($post['preview'])), 180),
        $anchor('continue', $link)
      ]); ?></p>
    </article>
  <?php } ?>
  <?php if(count($pages) > 1) { ?>
    <aside>
      <nav>
        <?php foreach(array_keys($pages) as $key) { ?>
          <?php if($key == $page) { ?>
            <span><?= $key; ?></span>
          <?php } else { ?>
            <?= $anchor($key, path(scribe('/posts/:page', [
              ':page' => $key == 1 ? null : $key
            ]))); ?>
          <?php } ?>
        <?php } ?>
      </nav>
      <?php foreach([
        '&larr;' => $page - 1, 
        '&rarr;' => $page + 1
      ] as $arrow => $key) { ?>
        <?php if(isset($pages[$key])) { ?>
          <?= $anchor($arrow, path(scribe('/posts/:page', [
            ':page' => $key == 1 ? null : $key
          ]))); ?>
        <?php } else { ?>
          <span><?= $arrow; ?></span>
        <?php } ?>
      <?php } ?>
    </aside>
  <?php } ?>
<?php } ?>