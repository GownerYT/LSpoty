<?php

namespace App\Controllers;
use App\Models\PlaylistModel;
use App\Models\PlaylistTrackModel;
use App\Models\TrackModel;
use GuzzleHttp\Client;

class AlbumDetailsController extends BaseController
{
    public function index($id)
    {
        $client = new Client();
        $clientId = '25f50d27';

        // Album
        $apiUrl = "https://api.jamendo.com/v3.0/albums";
        $params = [
            'client_id' => $clientId,
            'format' => 'json',
            'id' => $id
        ];

        try {
            $response = $client->request('GET', $apiUrl, ['query' => $params]);
            $data = json_decode($response->getBody(), true);
            $album = $data['results'][0];
        } catch (\Exception $e) {
            log_message('error', "Error al cargar el album: " . $e->getMessage());
            return redirect()->to('/home')->with('error', 'No se pudo cargar el álbum.');
        }

        // Tracks
        $apiUrl = "https://api.jamendo.com/v3.0/tracks";
        $params = [
            'client_id' => $clientId,
            'format' => 'json',
            'album_id' => $album['id']
        ];

        try {
            $response = $client->request('GET', $apiUrl, ['query' => $params]);
            $data = json_decode($response->getBody(), true);
            $tracks = $data['results'];
        } catch (\Exception $e) {
            log_message('error', "Error al cargar las tracks: " . $e->getMessage());
            $tracks = [];
        }

        $totalSeconds = array_sum(array_column($tracks, 'duration'));
        $totalDuration = sprintf("%02d:%02d", floor($totalSeconds / 60), $totalSeconds % 60);

        $userPlaylists = [];
        $session = session();
        $userId = $session->get('user_id');

        if ($userId) {
            $playlistModel = new PlaylistModel();
            $userPlaylists = $playlistModel->where('user_id', $userId)->findAll();
        }

        return view('album_details', [
            'album' => $album,
            'tracks' => $tracks,
            'artist' => $album['artist_id'],
            'totalDuration' => $totalDuration,
            'userPlaylists' => $userPlaylists,
        ]);
    }

    public function post($id)
    {
        $request = $this->request;
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/sign-in');
        }

        $trackModel = new TrackModel();
        $playlistTrackModel = new PlaylistTrackModel();

        $trackId = $request->getPost('track_id');
        $playlistId = $request->getPost('playlist_id');

        $existingTrack = $trackModel->find($trackId);
        if (!$existingTrack) {
            $trackData = [
                'id' => $trackId,
                'name' => $request->getPost('track_name'),
                'artist_name' => $request->getPost('artist_name'),
                'player_url' => $request->getPost('audio_url'),
                'cover' => $request->getPost('cover'),
                'artist_id' => $request->getPost('artist_id'),
                'album_id' => $request->getPost('album_id'),
                'album_name' => $request->getPost('album_name'),
                'duration' => $request->getPost('duration')
            ];
            $trackModel->insert($trackData);
        }

        $existingLink = $playlistTrackModel
            ->where('playlist_id', $playlistId)
            ->where('track_id', $trackId)
            ->first();

        if (!$existingLink) {
            $playlistTrackModel->insert([
                'playlist_id' => $playlistId,
                'track_id' => $trackId,
            ]);
            return redirect()->to("/album/$id")->with('success', 'Track added to playlist');
        }

        return redirect()->to("/album/$id")->with('info', 'Track already in playlist');
    }
}
