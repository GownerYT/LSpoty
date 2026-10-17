<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/AlbumDetails.css') ?>">
</head>
<body>

<header>
    <div class="header-container">
        <h1 class="logo">LSpoty</h1>
        <nav>
            <ul class="nav">
                <?php if (isset($links)): ?>
                    <?php foreach ($links as $link): ?>
                        <li>
                            <a href="<?= site_url($link['href']) ?>" class="nav-link">
                                <?= esc($link['text']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>