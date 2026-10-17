<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;

class ArtistController extends Controller
{
    public function show($id)
    {
        $client = new Client();
        $clientId = '25f50d27';

        try {
            $response = $client->get("https://api.jamendo.com/v3.0/artists", [
                'query' => [
                    'client_id' => $clientId,
                    'format' => 'json',
                    'id' => $id
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['results'][0])) {
                $artist = $data['results'][0];
                $albums = $this->getAlbums($id, $client);

                return view('artist_details', [
                    'artist' => $artist,
                    'albums' => $albums
                ]);
            } else {
                return view('artist_details', [
                    'error' => 'Artista no encontrado.'
                ]);
            }
        } catch (\Exception $e) {
            return view('artist_details', [
                'error' => 'Error al obtener información del artista.'
            ]);
        }
    }

    private function getAlbums($artistId, $client)
    {
        try {
            $response = $client->get("https://api.jamendo.com/v3.0/albums", [
                'query' => [
                    'client_id' => '25f50d27',
                    'artist_id' => $artistId,
                    'format' => 'json'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['results'] ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function postDetails($id)
    {
        return redirect()->to('/artist/' . $id);
    }
}
