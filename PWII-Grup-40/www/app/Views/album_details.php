<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <title><?= esc($album['name']) ?> - <?= lang('App.album_details') ?></title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/AlbumDetails.css') ?>">
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

<main>
    <section class="album-info">
        <img src="<?= !empty($album['image']) ? esc($album['image']) : base_url('/uploads/img/defaultForAll.png') ?>" alt="<?= lang('App.album_cover_alt') ?>" class="album-cover">

        <div class="album-meta">
            <h2><?= esc($album['name']) ?></h2>
            <p><?= lang('App.artist') ?>
                <a href="<?= site_url('artist/' . esc($album['artist_id'])) ?>">
                    <?= esc($album['artist_name']) ?>
                </a>
            </p>
            <p><?= lang('App.release_date') ?>: <?= esc($album['releasedate']) ?></p>
            <p><?= lang('App.total_duration') ?>: <?= esc($totalDuration) ?></p>

            <?php if (!empty($album['zip_allowed']) && $album['zip_allowed'] && !empty($album['zip'])): ?>
                <a class="download-btn" href="<?= esc($album['zip']) ?>" target="_blank"><?= lang('App.download_album') ?></a>
            <?php else: ?>
                <p class="no-download"><?= lang('App.download_not_available') ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="track-list">
        <h3><?= lang('App.tracks') ?></h3>
        <ul>
            <?php foreach ($tracks as $track): ?>
                <li class="track-item">
                    <strong><?= esc($track['name']) ?></strong>

                    <?php if (!empty($track['audio'])): ?>
                        <br>
                        <audio controls src="<?= esc($track['audio']) ?>"></audio>
                    <?php endif; ?>

                    <?php if (!empty($userPlaylists)): ?>
                        <div class="buttonss-form-container">
                            <form method="post" action="<?= site_url('album/' . $album['id']) ?>" class="playlist-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="track_id" value="<?= esc($track['id']) ?>">
                                <input type="hidden" name="track_name" value="<?= esc($track['name']) ?>">
                                <input type="hidden" name="artist_name" value="<?= esc($album['artist_name']) ?>">
                                <input type="hidden" name="audio_url" value="<?= esc($track['audio']) ?>">
                                <input type="hidden" name="cover" value="<?= esc($album['image']) ?>">
                                <input type="hidden" name="artist_id" value="<?= esc($album['artist_id']) ?>">
                                <input type="hidden" name="album_id" value="<?= esc($album['id']) ?>">
                                <input type="hidden" name="album_name" value="<?= esc($album['name']) ?>">
                                <input type="hidden" name="duration" value="<?= esc($track['duration']) ?>">

                                <label for="playlist"><?= lang('App.add_to') ?>:</label>
                                <select name="playlist_id" required>
                                    <?php foreach ($userPlaylists as $playlist): ?>
                                        <option value="<?= esc($playlist['id']) ?>"><?= esc($playlist['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="add-button"><?= lang('App.add') ?></button>
                            </form>

                        </div>
                    <?php else: ?>
                        <p class="no-playlists-msg"><?= lang('App.no_playlists_available') ?></p>
                    <?php endif; ?>
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
