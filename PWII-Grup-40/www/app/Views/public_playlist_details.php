<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <title><?= esc($playlist['name']) ?> - LSpoty</title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/public_playlist_details.css') ?>">
</head>
<body>

<header>
    <div class="header-container">
        <h1><a href="<?= site_url('home') ?>" class="logo">LSPOTY</a></h1>
        <nav>
            <ul>
                <li><a href="<?= site_url('home') ?>" class="nav-link"><?= lang('App.home') ?></a></li>
                <li><a href="<?= site_url('my-playlists') ?>" class="nav-link"><?= lang('App.myPlaylists') ?></a></li>
                <li><a href="<?= site_url('logout') ?>" class="nav-link"><?= lang('App.logout') ?></a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=en' ?>" class="nav-link">EN</a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=es' ?>" class="nav-link">ES</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="playlist-details-container">

    <div class="playlist-header">
        <img
                src="<?= !empty($playlist['image']) ? esc($playlist['image']) : '/uploads/img/defaultForAll.png' ?>"
                alt="<?= lang('App.playlistCoverAlt', ['name' => esc($playlist['name'])]) ?>"
                class="playlist-cover"
        >

        <div class="playlist-info">
            <h2><?= esc($playlist['name']) ?></h2>
            <p><strong><?= lang('App.createdBy') ?>:</strong> <?= esc($playlist['user_name'] ?? lang('App.unknown')) ?></p>
            <p><strong><?= lang('App.totalTracks') ?>:</strong> <?= count($playlist['tracks']) ?></p>
            <p><strong><?= lang('App.totalDuration') ?>:</strong> <?= gmdate("H:i:s", $duration) ?></p>

            <form method="POST" action="<?= site_url('my-playlists/save') ?>">
                <input type="hidden" name="playlist_name" value="<?= esc($playlist['name']) ?>">
                <input type="hidden" name="playlist_cover" value="<?= !empty($playlist['image']) ? esc($playlist['image']) : '/uploads/img/defaultForAll.png' ?>">
                <input type="hidden" name="playlist_id" value="<?= esc($playlist['id']) ?>">
                <button type="submit" class="save-button"><?= lang('App.saveToMyPlaylists') ?></button>
            </form>
        </div>
    </div>

    <section class="tracklist">
        <h3><?= lang('App.trackList') ?></h3>
        <ul>
            <?php foreach ($playlist['tracks'] as $track): ?>
                <li class="track-item">
                    <div class="track-info">
                        <p><strong><?= esc($track['name']) ?></strong></p>
                        <p>
                            <?= lang('App.artist') ?>:
                            <a href="<?= site_url('artist/' . esc($track['artist_id'])) ?>">
                                <?= esc($track['artist_name']) ?>
                            </a>
                        </p>
                        <?php if (!empty($track['album_name'])): ?>
                            <p><?= lang('App.album') ?>: <?= esc($track['album_name']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="track-actions">
                        <?php if (!empty($track['audio'])): ?>
                            <audio controls>
                                <source src="<?= esc($track['audio']) ?>" type="audio/mpeg">
                                <?= lang('App.audioNotSupported') ?>
                            </audio>
                        <?php else: ?>
                            <span class="no-preview"><?= lang('App.noPreview') ?></span>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

</main>

<footer>
    <p>&copy; 2025 LSpoty</p>
</footer>

</body>
</html>
