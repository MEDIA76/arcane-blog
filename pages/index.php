<?php

if(path(1) == 'post') {
  $posts = array_column($posts, null, 'slug');
  $post = $posts[path(2)];

  define('ROUTES', [
    ['post', array_keys($posts)]
  ]);

  if(array_key_exists('title', $post)) {
    relay('TITLE', trim(ltrim($post['title'], "#")));
  }
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
    <time>
      <span><?= date('M j, Y', $post['modified']); ?></span>
      <span><?= $readtime($post['content']); ?></span>
    </time>
    <?= $markdown($post['content']); ?>
  </article>
<?php } else { ?>
  <?php foreach($posts as $post) { ?>
    <article>
      <time>
        <span><?= date('M j, Y', $post['modified']); ?></span>
        <span><?= $readtime($post['content']); ?></span>
      </time>
      <?php $link = path("/post/{$post['slug']}/"); ?>
      <?php if(array_key_exists('title', $post)) { ?>
        <?php $regex = "/^[\s]*(\#+)\s+(.+)$/"; ?>
        <?= $markdown([
          preg_replace($regex, "$1 [$2]($link)", $post['title'])
        ]); ?>
      <?php } ?>
      <p><?= implode('&nbsp;', [
        $truncate(strip_tags($markdown($post['preview'])), 180),
        $anchor('continue', $link)
      ]); ?></p>
    </article>
  <?php } ?>
  <?php if(count($pages) > 1) { ?>
    <?php $path = path(2) ?? 1; ?>
    <aside>
      <?php if($pages[$prev = $path - 1] ?? false) { ?>
        <?php $link = path($prev == 1 ? '/' : "/page/{$prev}/"); ?>
        <a href="<?= $link; ?>">&larr;</a>
      <?php } else { ?>
        <span>&larr;</span>
      <?php } ?>
      <nav>
        <?php foreach(array_keys($pages) as $page) { ?>
          <?php if($page == $path) { ?>
            <span><?= $page; ?></span>
          <?php } else { ?>
            <?php $link = path($page == 1 ? '/' : "/page/{$page}/"); ?>
            <a href="<?= $link; ?>"><?= $page; ?></a>
          <?php } ?>
        <?php } ?>
      </nav>
      <?php if($pages[$next = $path + 1] ?? false) { ?>
        <a href="<?= path("/page/{$next}/"); ?>">&rarr;</a>
      <?php } else { ?>
        <span>&rarr;</span>
      <?php } ?>
    </aside>
  <?php } ?>
<?php } ?>