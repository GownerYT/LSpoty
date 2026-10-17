<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing Page
$routes->get('/', 'LandingPageController::index', ['filter' => 'land']);

// Sign-up
$routes->get('/sign-up', 'AuthController::getRegister');
$routes->post('/sign-up', 'AuthController::postRegister');
$routes->get('/sign-up-success', 'AuthController::signUpSuccess');

// Sign-in
$routes->get('/sign-in', 'AuthController::getLogin');
$routes->post('/sign-in', 'AuthController::postLogin');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Homepage
    $routes->get('/home', 'HomeController::index');

// User Profile
    $routes->get('/profile', 'UserProfileController::index');
    $routes->post('/profile', 'UserProfileController::update');
    $routes->post('/profile/delete', 'UserProfileController::delete');

// Artist Details
    $routes->get('/artist/(:num)', 'ArtistController::show/$1');
    $routes->post('/artist/(:num)', 'ArtistController::postDetails/$1');

// Album Details
    $routes->get('/album/(:num)', 'AlbumDetailsController::index/$1');
    $routes->post('/album/(:num)', 'AlbumDetailsController::post/$1');

// Playlist Details
    $routes->get('/playlist/(:num)', 'PlaylistDetailsController::index/$1');
    $routes->post('/playlist/(:num)', 'PlaylistDetailsController::index/$1');

// My Playlists
    $routes->get('/my-playlists', 'MyPlaylistsController::index');
    $routes->get('my-playlists/(:num)', 'MyPlaylistsController::show/$1');
    $routes->post('my-playlists/(:num)', 'MyPlaylistsController::postMyPlaylists/$1');
    $routes->post('my-playlists/save', 'MyPlaylistsController::save');

// Create Playlist
    $routes->get('/create-playlist', 'CreatePlaylistController::index');
    $routes->post('/create-playlist', 'CreatePlaylistController::store');

// My Playlists Management
    $routes->put('/my-playlists/(:num)', 'MyPlaylistsController::update/$1');
    $routes->delete('/my-playlists/(:num)', 'MyPlaylistsController::deletePlaylist/$1');
    $routes->put('my-playlists/(:num)/track/(:num)', 'MyPlaylistsController::addTrack/$1/$2');
    $routes->delete('my-playlists/(:num)/track/(:num)', 'MyPlaylistsController::deleteTrack/$1/$2');
});

// Logout
$routes->get('/logout', 'AuthController::logout');
