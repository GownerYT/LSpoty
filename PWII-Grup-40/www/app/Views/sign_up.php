<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSpoty - <?= lang('App.signin') ?></title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/SignUp.css') ?>">
</head>
<body>

<header>
    <div class="header-container">
        <h1><a href="<?= site_url('') ?>" class="logo">LSpoty</a></h1>
        <nav>
            <ul>
                <li><a href="<?= site_url('') ?>" class="nav-link"><?= lang('App.home') ?></a></li>
                <li><a href="<?= site_url('') ?>" class="nav-link"><?= lang('App.login') ?></a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=en' ?>" class="nav-link">EN</a></li>
                <li><a href="<?= site_url(uri_string()) . '?lang=es' ?>" class="nav-link">ES</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <h2><?= lang('App.register') ?></h2>

        <form method="POST" action="<?= site_url('sign-up') ?>" enctype="multipart/form-data">

            <div>
                <label>
                    <input type="text" name="inputUserName" placeholder="<?= lang('App.username') ?>" value="<?= set_value('inputUserName') ?>">
                </label>
                <div class="error"><?= \Config\Services::validation()->showError('inputUserName') ?></div>
            </div>

            <div>
                <label id="profilePicLabel"><?= lang('App.profile_picture') ?></label>
                <input type="file" id="inputUserProfilePic" name="inputUserProfilePic" accept="image/jpeg, image/png">
                <div class="error"><?= \Config\Services::validation()->showError('inputUserProfilePic') ?></div>
            </div>

            <div>
                <label>
                    <input type="email" name="inputUserEmail" placeholder="<?= lang('App.email_placeholder') ?>" value="<?= set_value('inputUserEmail') ?>">
                </label>
                <div class="error"><?= \Config\Services::validation()->showError('inputUserEmail') ?></div>
            </div>

            <div>
                <label>
                    <input type="password" name="inputUserPassword" placeholder="<?= lang('App.password_placeholder') ?>">
                </label>
                <div class="error"><?= \Config\Services::validation()->showError('inputUserPassword') ?></div>
            </div>

            <div>
                <label>
                    <input type="password" name="inputRepeatPassword" placeholder="<?= lang('App.repeat_password') ?>">
                </label>
                <div class="error"><?= \Config\Services::validation()->showError('inputRepeatPassword') ?></div>
            </div>

            <button type="submit"><?= lang('App.register') ?></button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>

</body>
</html>
