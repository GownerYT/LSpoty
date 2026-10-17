<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <title><?= lang('App.artist_details') ?></title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/artist_details.css') ?>">
</head>
<body>

<header>
    <div class="header-container">
        <h1><a href="<?= site_url('home') ?>" class="logo">LSPOTY</a></h1>
        <nav>
            <ul>
                <li><a href="<?= site_url('home') ?>" class="nav-link"><?= lang('App.home') ?></a></li>
                <li><a href="<?= site_url('my-playlists') ?>" class="nav-link"><?= lang('App.my_playlists') ?></a></li>
                <li><a href="<?= site_url('profile') ?>" class="nav-link"><?= lang('App.my_profile') ?></a></li>
                <li><a href="<?= site_url('logout') ?>" class="nav-link"><?= lang('App.logout') ?></a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=en' ?>" class="nav-link">EN</a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=es' ?>" class="nav-link">ES</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="artist-container">
    <?php if (isset($error)): ?>
        <p class="error"><?= esc($error) ?></p>
    <?php else: ?>
        <h1><?= esc($artist['name']) ?></h1>

        <?php
        $imageSrc = !empty($artist['image'])
            ? esc($artist['image'])
            : base_url('uploads/img/defaultForAll.png');
        ?>
        <img src="<?= $imageSrc ?>" alt="<?= esc($artist['name']) ?>" class="artist-image">

        <p><strong><?= lang('App.join_date') ?>:</strong> <?= date('j F, Y', strtotime($artist['joindate'])) ?></p>

        <h2><?= lang('App.artist_albums') ?></h2>
        <?php if (!empty($albums)): ?>
            <div class="albums-list">
                <?php foreach ($albums as $album): ?>
                    <div class="album-card">
                        <a href="<?= site_url('album/' . esc($album['id'])) ?>">
                            <img class="album-cover" src="<?= esc($album['image']) ?: base_url('uploads/img/defaultForAll.png') ?>" alt="<?= lang('App.cover_of') ?> <?= esc($album['name']) ?>">
                        </a>
                        <div class="album-info">
                            <a href="<?= site_url('album/' . esc($album['id'])) ?>" class="album-name"><?= esc($album['name']) ?></a>
                            <p class="release-date"><?= lang('App.released') ?>: <?= date('j F, Y', strtotime($album['releasedate'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p><?= lang('App.no_albums_yet') ?></p>
        <?php endif; ?>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>
</body>
</html>
