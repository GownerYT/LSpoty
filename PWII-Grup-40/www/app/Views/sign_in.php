<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSpoty - <?= lang('App.login') ?></title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/SignIn.css') ?>">
</head>
<body>

<header>
    <div class="header-container">
        <h1><a href="<?= site_url('') ?>" class="logo">LSpoty</a></h1>
        <nav>
            <ul>
                <li><a href="<?= site_url('') ?>" class="nav-link"><?= lang('App.home') ?></a></li>
                <li><a href="<?= site_url('sign-up') ?>" class="nav-link"><?= lang('App.signin') ?></a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=en' ?>" class="nav-link">EN</a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=es' ?>" class="nav-link">ES</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <h2><?= lang('App.login') ?></h2>

        <?php if (session()->has('error')): ?>
            <div class="error"><?= session('error') ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= site_url('sign-in') ?>">

            <div>
                <label>
                    <?php $userEmail = \Config\Services::request()->getCookie('user_email'); ?>
                    <input type="email" name="inputUserEmail" placeholder="<?= lang('App.email_placeholder') ?>" value="<?= old('inputUserEmail', $userEmail) ?>">

                </label>
                <div class="error"><?= \Config\Services::validation()->showError('inputUserEmail') ?></div>
            </div>

            <div>
                <label>
                    <input type="password" name="inputUserPassword" placeholder="<?= lang('App.password_placeholder') ?>">
                </label>
                <div class="error"><?= \Config\Services::validation()->showError('inputUserPassword') ?></div>
            </div>

            <button type="submit"><?= lang('App.submit_login') ?></button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>

</body>
</html>
