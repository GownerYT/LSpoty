<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSpoty <?= lang('App.profile') ?></title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/profile.css') ?>">
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

<main class="profile-container">
    <div class="container">
        <h1><?= lang('App.my_profile') ?></h1>

        <?php if (session()->getFlashdata('success')): ?>
            <p class="success"><?= esc(session()->getFlashdata('success')) ?></p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <ul class="errors">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (isset($user)): ?>
            <form method="post" action="<?= base_url('/profile') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="username"><?= lang('App.username') ?>:</label>
                    <input type="text" id="username" name="username" value="<?= esc($user['username']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email"><?= lang('App.email') ?>:</label>
                    <input type="email" id="email" value="<?= esc($user['email']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="age"><?= lang('App.age') ?>:</label>
                    <input type="number" id="age" name="age" value="<?= esc($user['age']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="password"><?= lang('App.new_password') ?>:</label>
                    <input type="password" id="password" name="password" placeholder="<?= lang('App.keep_current_password') ?>">
                </div>

                <div class="form-group">
                    <label for="profile_pic"><?= lang('App.profile_picture') ?>:</label>
                    <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
                </div>

                <button type="submit" class="submit-btn"><?= lang('App.update_profile') ?></button>
            </form>

            <form method="post" action="<?= base_url('/profile/delete') ?>" onsubmit="return confirm('<?= lang('App.confirm_delete') ?>');">
                <?= csrf_field() ?>
                <button type="submit" class="delete-btn"><?= lang('App.delete_account') ?></button>
            </form>
        <?php else: ?>
            <p><?= lang('App.user_data_not_found') ?></p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>

</body>
</html>
