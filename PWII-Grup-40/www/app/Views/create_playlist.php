<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('App.create_playlist') ?> | LSpoty</title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/create_playlist.css') ?>">
</head>
<body>

<header>
    <div class="header-container">
        <h1><a href="<?= site_url('home') ?>" class="logo">LSpoty</a></h1>
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

<main class="form-container">
    <div class="container">
        <h2><?= lang('App.create_new_playlist') ?></h2>

        <form action="<?= site_url('create-playlist') ?>" method="post">
            <div class="form-group">
                <label for="name"><?= lang('App.playlist_name') ?>:</label>
                <input type="text" name="name" id="name" placeholder="<?= lang('App.enter_playlist_name') ?>" required>
            </div>

            <div class="form-group">
                <label for="cover"><?= lang('App.cover_url_optional') ?>:</label>
                <input type="text" name="cover" id="cover" placeholder="https://..." />
            </div>

            <button type="submit" class="submit-btn"><?= lang('App.create_playlist') ?></button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>

</body>
</html>
