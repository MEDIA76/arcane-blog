<?php

$regex = "/^[\s]*(\#{1,6})\s+(.+)$/";

if(path(1) == 'post') {
  $posts = array_column($posts, null, 'slug');
  $post = $posts[path(2)];

  define('ROUTES', [
    ['post', array_keys($posts)]
  ]);

  relay('TITLE', preg_replace($regex, '$2', $post['head']));
} else {
  $pages = $paginate($posts, 5);
  $posts = $pages[path(2) ?? 1];

  define('ROUTES', [
    ['page', range(2, count($pages))]
  ]);
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
      <?php $link = path("/post/{$post['slug']}/"); ?>
      <?= $markdown($truncate($post['content'], 200, "...&nbsp;[continue]($link)"), [
        $post['head'] => preg_replace($regex, "$1 [$2]($link)", $post['head'])
      ]); ?>
    </article>
  <?php } ?>
  <?php if(count($pages) > 1) { ?>
    <aside>
      <?php if(array_key_exists($prev = (path(2) ?? 1) - 1, $pages)) { ?>
        <a href="<?= path($prev == 1 ? '/' : "/page/{$prev}/"); ?>">&larr;</a>
      <?php } else { ?>
        <span>&larr;</span>
      <?php } ?>
      <nav>
        <?php foreach(array_keys($pages) as $page) { ?>
          <?php if($page == (path(2) ?? 1)) { ?>
            <span><?= $page; ?></span>
          <?php } else { ?>
            <?php $reference = path($page == 1 ? '/' : "/page/{$page}/"); ?>
            <a href="<?= $reference; ?>"><?= $page; ?></a>
          <?php } ?>
        <?php } ?>
      </nav>
      <?php if(array_key_exists($next = (path(2) ?? 1) + 1, $pages)) { ?>
        <a href="<?= path("/page/{$next}/"); ?>">&rarr;</a>
      <?php } else { ?>
        <span>&rarr;</span>
      <?php } ?>
    </aside>
  <?php } ?>
<?php } ?>