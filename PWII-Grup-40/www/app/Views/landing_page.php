<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSpoty Landing</title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/LandingPage.css') ?>">
</head>
<body>

<header>
    <div class="header-container">
        <h1 class="logo">LSpoty</h1>
        <nav>
            <ul>
                <li><a href="<?= site_url('sign-in') ?>" class="nav-link"><?= lang('App.login') ?></a></li>
                <li><a href="<?= site_url('sign-up') ?>" class="nav-link"><?= lang('App.signin') ?></a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=en' ?>" class="nav-link">EN</a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=es' ?>" class="nav-link">ES</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <section class="intro-section">
        <div class="intro-content">
            <h2><?= lang('App.welcome_title') ?></h2>
            <div class="cta-buttons">
                <a href="<?= site_url('sign-in') ?>" class="cta-button"><?= lang('App.login') ?></a>
                <a href="<?= site_url('sign-up') ?>" class="cta-button"><?= lang('App.signin') ?></a>
            </div>
        </div>
    </section>
    <section class="features">
        <div class="feature">
            <h3><?= lang('App.feature_1_title') ?></h3>
            <p><?= lang('App.feature_1_desc') ?></p>
        </div>
        <div class="feature">
            <h3><?= lang('App.feature_2_title') ?></h3>
            <p><?= lang('App.feature_2_desc') ?></p>
        </div>
        <div class="feature">
            <h3><?= lang('App.feature_3_title') ?></h3>
            <p><?= lang('App.feature_3_desc') ?></p>
        </div>
    </section>
</main>

<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>

</body>
</html>
