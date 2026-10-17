<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSpoty <?= lang('App.playlists') ?></title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/my_playlists.css') ?>">
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
    <section class="playlist-overview">
        <h2><?= lang('App.my_playlists') ?></h2>
        <button class="create-playlist-btn" onclick="location.href='<?= site_url('create-playlist') ?>'">
            <?= lang('App.create_new_playlist') ?>
        </button>
        <div class="playlists-grid">
            <?php foreach ($playlists as $playlist): ?>
                <div class="playlist-card">
                    <img src="<?= esc($playlist['cover']) ?>" alt="<?= lang('App.cover_alt') ?>">
                    <h3><?= esc($playlist['name']) ?></h3>
                    <h4><?= lang('App.totalTracks')?>: <?= esc($numTracks[$playlist['id']]) ?></h4>
                    <button onclick="location.href='<?= site_url('my-playlists/' . $playlist['id']) ?>'"><?= lang('App.view') ?></button>
                    <div id="player-container" style="display:none;">
                        <audio id="audio-player" controls></audio>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</main>

<script>
    const playlists = {};

    <?php foreach ($tracks as $playlistId => $playlistTracks): ?>
    playlists[<?= $playlistId ?>] = [];
    <?php foreach ($playlistTracks as $track): ?>
    playlists[<?= $playlistId ?>].push({
        id: <?= $track['id'] ?>,
        name: "<?= esc($track['name']) ?>",
        url: "<?= esc($track['player_url']) ?>"
    });
    <?php endforeach; ?>
    <?php endforeach; ?>
</script>


<script src="<?= base_url('/assets/js/my_playlists_audio.js') ?>"></script>


<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>

</body>
</html>
