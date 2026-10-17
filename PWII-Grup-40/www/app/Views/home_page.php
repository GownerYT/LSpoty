<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSpoty Home</title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/HomePage.css') ?>">
</head>
<body>
<header>
    <div class="header-container">
        <h1 class="logo">LSpoty</h1>
        <nav>
            <ul>
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
    <section class="search-section">
        <h2><?= lang('App.discover_search') ?></h2>
        <h5><?= lang('App.explore_collection') ?></h5>

        <form id="search-form" method="GET" action="<?= site_url('home') ?>">
            <input type="text" name="query" id="search-input" placeholder="<?= lang('App.search_placeholder') ?>" value="<?= old('query', $query) ?>">
            <select name="filter" id="search-filter">
                <option value="tracks" <?= ($filter === 'tracks') ? 'selected' : '' ?>><?= lang('App.tracks') ?></option>
                <option value="albums" <?= ($filter === 'albums') ? 'selected' : '' ?>><?= lang('App.albums') ?></option>
                <option value="artists" <?= ($filter === 'artists') ? 'selected' : '' ?>><?= lang('App.artists') ?></option>
                <option value="playlists" <?= ($filter === 'playlists') ? 'selected' : '' ?>><?= lang('App.playlists') ?></option>
            </select>
            <button type="submit" class="search-button"><?= lang('App.search_button') ?></button>
        </form>
    </section>

    <section class="search-results">
        <?php if (!empty($query) && !empty($results)): ?>
            <h3 id="search-title"><?= lang('App.search_results') ?></h3>
            <ul id="results-list">
                <?php foreach ($results as $item): ?>
                    <li class="result-item">
                        <img src="<?= (!empty($item['image'])) ? $item['image'] : '/uploads/img/defaultForAll.png' ?>" alt="image" class="result-image">
                        <div class="text-container">
                            <?php switch ($filter):
                                case 'tracks': ?>
                                    <h4><?= $item['name'] ?></h4>
                                    <p><?= lang('App.artist') ?>
                                        <a href="<?= site_url('artist/' . $item['artist_id']) ?>" class="artist-link">
                                            <?= $item['artist_name'] ?>
                                        </a>
                                    </p>
                                    <p><?= $item['album_name'] ? "Álbum: " . $item['album_name'] : lang('App.no_album') ?></p>

                                    <div class="buttons-container">
                                    <?php if (!empty($item['audio'])): ?>
                                        <button class="play-button" data-audio="<?= $item['audio'] ?>"><?= lang('App.play') ?></button>
                                        <button class="stop-button" style="display:none;"><?= lang('App.stop') ?></button>
                                        <audio class="audio-player" style="display:none;">
                                            <source src="<?= $item['audio'] ?>" type="audio/mpeg">
                                            <?= lang('App.not_supported') ?>
                                        </audio>
                                        </div>
                                        <?php if (!empty($userPlaylists)): ?>
                                            <div class="buttonss-form-container">
                                                <form method="post"
                                                      action="<?= site_url('my-playlists') ?>/__PLAYLIST_ID__/track/<?= $item['id'] ?>"
                                                      class="playlist-form"
                                                      data-track-id="<?= $item['id'] ?>">
                                                <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <input type="hidden" name="track_id" value="<?= $item['id'] ?>">
                                                    <input type="hidden" name="track_name" value="<?= $item['name'] ?>">
                                                    <input type="hidden" name="artist_name" value="<?= $item['artist_name'] ?>">
                                                    <input type="hidden" name="audio_url" value="<?= $item['audio'] ?>">
                                                    <input type="hidden" name="cover" value="<?= $item['image'] ?>">
                                                    <input type="hidden" name="artist_id" value="<?= $item['artist_id'] ?>">
                                                    <input type="hidden" name="album_id" value="<?= $item['album_id'] ?>">
                                                    <input type="hidden" name="album_name" value="<?= $item['album_name'] ?>">
                                                    <input type="hidden" name="duration" value="<?= $item['duration'] ?>">

                                                    <label for="playlist"><?= lang('App.add_to') ?></label>
                                                    <select name="playlist_id" class="playlist-selector" required>
                                                        <?php foreach ($userPlaylists as $playlist): ?>
                                                            <option value="<?= $playlist['id'] ?>"><?= $playlist['name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit" class="add-button"><?= lang('App.add') ?></button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <p><?= lang('App.no_playlists') ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php break; ?>

                                <?php case 'albums': ?>
                                    <h4>
                                        <a href="<?= site_url('album/' . $item['id']) ?>" class="artist-link">
                                            <?= $item['name'] ?>
                                        </a>
                                    </h4>
                                    <p><?= lang('App.artist') ?>
                                        <a href="<?= site_url('artist/' . $item['artist_id']) ?>" class="artist-link">
                                            <?= $item['artist_name'] ?>
                                        </a>
                                    </p>
                                    <?php break; ?>

                                <?php case 'artists': ?>
                                    <h4>
                                        <a href="<?= site_url('artist/' . $item['id']) ?>" class="artist-link">
                                            <?= $item['name'] ?>
                                        </a>
                                    </h4>
                                    <p><?= lang('App.creation_date') ?> <?= $item['joindate'] ?: lang('App.no_album') ?></p>
                                    <?php break; ?>

                                <?php case 'playlists': ?>
                                    <h4>
                                        <a href="<?= site_url('playlist/' . $item['id']) ?>" class="artist-link">
                                            <?= $item['name'] ?>
                                        </a>
                                    </h4>
                                    <p><?= lang('App.creation_date') ?> <?= $item['creationdate'] ?: lang('App.no_album') ?></p>
                                    <p><?= lang('App.user') ?> <?= $item['user_name'] ?></p>
                                    <?php break; ?>

                                <?php default: ?>
                                    <p><?= lang('App.unknown_result_type') ?></p>
                                <?php endswitch; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <h3><?= lang('App.featured_content') ?></h3>
            <ul id="results-list">
                <?php foreach ($featuredContent as $category => $items): ?>
                    <li class="result-item" style="flex-direction: column; align-items: flex-start;">
                        <h4><?= ucfirst($category) ?></h4>
                        <ul style="width: 100%;">
                            <?php foreach ($items as $item): ?>
                                <li class="result-item">
                                    <img src="<?= (!empty($item['image'])) ? $item['image'] : '/uploads/img/defaultForAll.png' ?>" class="result-image" alt="image">
                                    <div class="text-container">
                                        <?php if ($category === 'artists'): ?>
                                            <h4>
                                                <a href="<?= site_url('artist/' . $item['id']) ?>" class="artist-link">
                                                    <?= $item['name'] ?>
                                                </a>
                                            </h4>
                                            <p><?= lang('App.creation_date') ?> <?= $item['joindate'] ?: lang('App.no_album') ?></p>
                                        <?php elseif ($category === 'albums'): ?>
                                            <h4>
                                                <a href="<?= site_url('album/' . $item['id']) ?>" class="artist-link">
                                                    <?= $item['name'] ?>
                                                </a>
                                            </h4>
                                            <?php if (!empty($item['artist_name']) && !empty($item['artist_id'])): ?>
                                                <p><?= lang('App.artist') ?>
                                                    <a href="<?= site_url('artist/' . $item['artist_id']) ?>" class="artist-link">
                                                        <?= $item['artist_name'] ?>
                                                    </a>
                                                </p>
                                            <?php endif; ?>
                                        <?php elseif ($category === 'playlists'): ?>
                                            <h4>
                                                <a href="<?= site_url('playlist/' . $item['id']) ?>" class="artist-link">
                                                    <?= $item['name'] ?>
                                                </a>
                                            </h4>
                                            <p><?= lang('App.creation_date') ?> <?= $item['creationdate'] ?: lang('App.no_album') ?></p>
                                            <p><?= lang('App.user') ?> <?= $item['user_name'] ?></p>
                                        <?php elseif ($category === 'tracks'): ?>
                                        <h4><?= $item['name'] ?></h4>
                                        <?php if (!empty($item['artist_name']) && !empty($item['artist_id'])): ?>
                                            <p><?= lang('App.artist') ?>
                                                <a href="<?= site_url('artist/' . $item['artist_id']) ?>" class="artist-link">
                                                    <?= $item['artist_name'] ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                        <div class="buttons-container">
                                            <?php if (!empty($item['audio'])): ?>
                                            <button class="play-button" data-audio="<?= $item['audio'] ?>"><?= lang('App.play') ?></button>
                                            <button class="stop-button" style="display:none;"><?= lang('App.stop') ?></button>
                                            <audio class="audio-player" style="display:none;">
                                                <source src="<?= $item['audio'] ?>" type="audio/mpeg">
                                                <?= lang('App.not_supported') ?>
                                            </audio>
                                        </div>
                                    <?php if (!empty($userPlaylists)): ?>
                                        <div class="buttonss-form-container">
                                            <form method="post"
                                                  action="<?= site_url('my-playlists') ?>/__PLAYLIST_ID__/track/<?= $item['id'] ?>"
                                                  class="playlist-form"
                                                  data-track-id="<?= $item['id'] ?>">
                                            <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="track_id" value="<?= $item['id'] ?>">
                                                <input type="hidden" name="track_name" value="<?= $item['name'] ?>">
                                                <input type="hidden" name="artist_name" value="<?= $item['artist_name'] ?>">
                                                <input type="hidden" name="audio_url" value="<?= $item['audio'] ?>">
                                                <input type="hidden" name="cover" value="<?= $item['image'] ?>">
                                                <input type="hidden" name="artist_id" value="<?= $item['artist_id'] ?>">
                                                <input type="hidden" name="album_id" value="<?= $item['album_id'] ?>">
                                                <input type="hidden" name="album_name" value="<?= $item['album_name'] ?>">
                                                <input type="hidden" name="duration" value="<?= $item['duration'] ?>">

                                                <label for="playlist"><?= lang('App.add_to') ?></label>
                                                <select name="playlist_id" class="playlist-selector" required>
                                                    <?php foreach ($userPlaylists as $playlist): ?>
                                                        <option value="<?= $playlist['id'] ?>"><?= $playlist['name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit" class="add-button"><?= lang('App.add') ?></button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <p><?= lang('App.no_playlists') ?></p>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</main>

<footer>
    <p>&copy; 2025 LSpoty.</p>
</footer>

<script src="<?= base_url('/assets/js/home_page_audio.js') ?>"></script>
<script src="<?= base_url('/assets/js/home_page_add_track.js') ?>"></script>

</body>
</html>
