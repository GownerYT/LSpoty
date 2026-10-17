<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($playlist['name']) ?> | LSpoty</title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/playlist_details.css') ?>">
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

<main class="playlist-detail-container">
    <div class="playlist-header">
        <div class="playlist-cover">
            <img src="<?= esc($playlist['cover']) ?>" alt="<?= esc($playlist['name']) ?> cover">
        </div>
        <h2><?= esc($playlist['name']) ?></h2>
    </div>

    <div class="playlist-actions">
        <form method="post" action="<?= site_url('my-playlists/' . $playlist['id']) ?>">
            <input type="hidden" name="_method" value="PUT">
            <input type="text" name="new_name" placeholder="<?= lang('App.new_name') ?>" required>
            <button type="submit"><?= lang('App.rename') ?></button>
        </form>
        <form method="post" action="<?= site_url('my-playlists/' . $playlist['id']) ?>" onsubmit="return confirm('<?= lang('App.confirm_delete_playlist') ?>')">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" style="background-color: red;"><?= lang('App.delete_playlist') ?></button>
        </form>
    </div>

    <div class="playlist-duration">
        <p><strong><?= lang('App.totalTracks') ?>:</strong> <?= $numTracks ?></p>
    </div>

    <div class="track-list">
        <?php if (!empty($tracks)): ?>
            <ul>
                <?php foreach ($tracks as $index => $track): ?>
                    <li data-url="<?= esc($track['player_url']) ?>">
                        <?= esc($track['name']) ?> - <?= esc($track['artist_name']) ?>
                        <?php if ($track['player_url']): ?>
                            <button onclick="playNewTrack(<?= $index ?>)">▶️</button>
                            <form action="<?= site_url('my-playlists/' . $playlist['id'] . '/track/' . $track['id']) ?>" method="post" style="display:inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this track?')">🗑️</button>
                            </form>
                        <?php else: ?>
                            <span style="color: grey;">(<?= lang('App.no_preview') ?>)</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p><?= lang('App.no_tracks_in_playlist') ?></p>
        <?php endif; ?>
    </div>

    <div class="audio-player-container">
        <div class="progress-bar-container">
            <div class="left-controls">
                <button id="playPauseBtn">▶️</button>
                <button id="repeatBtn"
                        data-lang-repeat="<?= lang('App.repeat') ?>"
                        data-lang-enabled="<?= lang('App.enabled') ?>"
                        data-lang-disabled="<?= lang('App.disabled') ?>">🔁</button>
                <span id="currentTime" class="time-display">0:00</span>
            </div>
            <div class="progress-wrapper">
                <div id="progressBar" class="progress-bar"></div>
            </div>
            <span id="duration" class="time-display">0:00</span>
        </div>
        <audio id="audioPlayer" style="display: none;"></audio>
    </div>
</main>

<script src="<?= base_url('/assets/js/playlist_details.js') ?>"></script>

<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>

</body>
</html>
