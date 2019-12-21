<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="description" content="Blog Site">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php if(defined('TITLE')) echo TITLE . ' - '; ?>Blog Site</title>
    <link rel="icon" type="image/png" href="<?= path('images/favicon.png'); ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:700|Noto+Serif:400,400i,700,700i&display=swap" />
    <?= STYLES; ?>
  </head>
  <body>
    <section>
      <header>
        <a href="<?= path('/'); ?>">Blog Site</a>
        <nav>
          <a href="<?= path('/about/'); ?>"><?= scribe('About'); ?></a>
          <a href="https://twitter.com" target="_blank">
            <svg width="16" height="16" viewBox="0 0 16 16">
              <path d="M5.03 14.5c6.04 0 9.34-5 9.34-9.338 0-.142-.002-.284-.008-.424.64-.463 1.198-1.04 1.638-1.7-.588.262-1.22.438-1.885.518.678-.406 1.198-1.05 1.443-1.816-.634.376-1.337.65-2.084.797-.6-.638-1.452-1.037-2.396-1.037-1.813 0-3.283 1.47-3.283 3.28 0 .26.03.51.085.75C5.152 5.39 2.733 4.085 1.114 2.1.832 2.585.67 3.15.67 3.75c0 1.138.58 2.143 1.46 2.73-.538-.016-1.044-.164-1.487-.41v.042c0 1.59 1.13 2.916 2.633 3.217-.277.075-.567.116-.866.116-.21 0-.417-.02-.617-.06.418 1.305 1.63 2.254 3.067 2.28-1.124.88-2.54 1.405-4.077 1.405-.265 0-.526-.014-.783-.044 1.452.93 3.177 1.474 5.03 1.474" />
            </svg>
          </a>
        </nav>
      </header>
      <?= CONTENT; ?>
      <footer>
        <p>Copyright &copy; <?= date('Y'); ?></p>
        <p>Built with <a href="https://arcane.dev" target="_blank">Arcane</a></p>
      </footer>
    </section>
    <?= SCRIPTS; ?>
  </body>
</html>