<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use GuzzleHttp\Client;

class PlaylistDetailsController extends BaseController
{
    public function index($id): string
    {
        $client = new Client();
        $clientId = '25f50d27';
        $apiUrl = "https://api.jamendo.com/v3.0/playlists/tracks";

        $params = [
            'client_id' => $clientId,
            'format' => 'json',
            'id' => $id
        ];

        try {
            $response = $client->request('GET', $apiUrl, ['query' => $params]);
            $data = json_decode($response->getBody(), true);
            $playlist = $data['results'][0];

            session()->set("public_playlist_tracks_$id", $playlist['tracks']);

        } catch (\Exception $e) {
            log_message('error', "Error al cargar la playlist: " . $e->getMessage());
            throw PageNotFoundException::forPageNotFound("No se pudo cargar la playlist.");
        }

        $totalDuration = array_sum(array_column($playlist['tracks'], 'duration'));

        return view('public_playlist_details', [
            'playlist' => $playlist,
            'duration' => $totalDuration
        ]);
    }
}
