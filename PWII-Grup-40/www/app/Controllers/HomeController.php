<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use App\Models\PlaylistModel;

class HomeController extends Controller
{
    public function index()
    {
        $query = $this->request->getGet('query');
        $filter = $this->request->getGet('filter');

        $results = [];
        $featuredContent = [];

        $client = new Client();
        $clientId = '25f50d27';

        $session = session();
        $userId = $session->get('user_id');
        $userPlaylists = [];

        if ($userId) {
            $playlistModel = new PlaylistModel();
            $userPlaylists = $playlistModel->where('user_id', $userId)->findAll();
        }

        if (!empty($query) && !empty($filter)) {
            $apiUrl = "https://api.jamendo.com/v3.0/{$filter}";
            $queryParams = [
                'client_id' => $clientId,
                'format' => 'json',
                'limit' => 10,
                'name' => $query
            ];

            try {
                $response = $client->request('GET', $apiUrl, ['query' => $queryParams]);
                $data = json_decode($response->getBody(), true);
                $results = $data['results'] ?? [];
            } catch (\Exception $e) {
                log_message('error', 'Error al consultar la API: ' . $e->getMessage());
            }
        } else {
            $types = ['tracks', 'albums', 'artists'];
            foreach ($types as $type) {
                $apiUrl = "https://api.jamendo.com/v3.0/{$type}";
                $params = [
                    'client_id' => $clientId,
                    'format' => 'json',
                    'limit' => 5,
                    'order' => 'popularity_week'
                ];

                try {
                    $response = $client->request('GET', $apiUrl, ['query' => $params]);
                    $data = json_decode($response->getBody(), true);
                    $featuredContent[$type] = $data['results'] ?? [];
                } catch (\Exception $e) {
                    log_message('error', "Error al cargar contenido destacado ($type): " . $e->getMessage());
                }
            }

            $apiUrl = "https://api.jamendo.com/v3.0/playlists";
            $params = [
                'client_id' => $clientId,
                'format' => 'json',
                'limit' => 5,
                'order' => 'creationdate_desc'
            ];

            try {
                $response = $client->request('GET', $apiUrl, ['query' => $params]);
                $data = json_decode($response->getBody(), true);
                $featuredContent['playlists'] = $data['results'] ?? [];
            } catch (\Exception $e) {
                log_message('error', "Error al cargar contenido destacado (playlists): " . $e->getMessage());
            }
        }

        return view('home_page', [
            'results' => $results,
            'query' => $query,
            'filter' => $filter,
            'featuredContent' => $featuredContent,
            'userPlaylists' => $userPlaylists
        ]);
    }
}
