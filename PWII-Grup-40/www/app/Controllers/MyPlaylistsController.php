<?php

namespace App\Controllers;

use App\Models\PlaylistModel;
use App\Models\TrackModel;
use App\Models\PlaylistTrackModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MyPlaylistsController extends BaseController
{
    public function index(): string
    {
        $userId = session()->get('user_id');
        $playlistModel = new PlaylistModel();
        $playlists = $playlistModel->where('user_id', $userId)->findAll();

        $tracks = [];
        $numTracks = [];

        $playlistTrackModel = new PlaylistTrackModel();
        $trackModel = new TrackModel();

        foreach ($playlists as $playlist) {
            $playlistId = $playlist['id'];

            $playlistTrackLinks = $playlistTrackModel->where('playlist_id', $playlistId)->findAll();
            $trackIds = array_column($playlistTrackLinks, 'track_id');

            $playlistTracks = !empty($trackIds)
                ? $trackModel->whereIn('id', $trackIds)->findAll()
                : [];

            $tracks[$playlistId] = $playlistTracks;
            $numTracks[$playlistId] = count($playlistTracks);
        }

        return view('my_playlists', [
            'playlists' => $playlists,
            'tracks' => $tracks,
            'numTracks' => $numTracks,
        ]);
    }

    public function show($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/sign-in');
        }

        $playlistModel = new PlaylistModel();
        $trackModel = new TrackModel();
        $playlistTrackModel = new PlaylistTrackModel();

        $playlist = $playlistModel->find($id);
        if (!$playlist) {
            throw PageNotFoundException::forPageNotFound("Playlist no encontrada.");
        }

        $playlistTrackLinks = $playlistTrackModel->where('playlist_id', $id)->findAll();
        $trackIds = array_column($playlistTrackLinks, 'track_id');

        $tracks = !empty($trackIds)
            ? $trackModel->whereIn('id', $trackIds)->findAll()
            : [];

        foreach ($tracks as &$track) {
            $track['name'] = $track['name'] ?? 'Sin título';
            $track['artist_name'] = $track['artist_name'] ?? 'Desconocido';
            $track['player_url'] = $track['player_url'] ?? null;
        }

        $numTracks = count($tracks);
        $totalDuration = array_sum(array_column($tracks, 'duration'));

        return view('playlist_details', [
            'playlist' => $playlist,
            'tracks' => $tracks,
            'numTracks' => $numTracks,
            'totalDuration' => $totalDuration
        ]);
    }

    public function postMyPlaylists($id)
    {
        $action = $this->request->getPost('action');

        if (!$action) {
            return redirect()->back()->with('error', 'No action specified.');
        }

        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->find($id);

        if (!$playlist) {
            return redirect()->to('/my-playlists')->with('error', 'Playlist not found.');
        }

        if ($action === 'rename') {
            $newName = $this->request->getPost('new_name');
            if (!$newName) {
                return redirect()->back()->with('error', 'Invalid playlist name.');
            }

            $playlistModel->update($id, ['name' => $newName]);
            return redirect()->to("/my-playlists/$id")->with('success', 'Playlist renamed successfully.');
        }

        if ($action === 'delete') {
            $playlistModel->delete($id);
            return redirect()->to('/my-playlists')->with('success', 'Playlist deleted successfully.');
        }

        return redirect()->back()->with('error', 'Invalid action.');
    }

    public function update($id)
    {
        $playlistModel = new PlaylistModel();
        $newName = $this->request->getPost('new_name');

        if (!$newName) {
            return redirect()->back()->with('error', 'Nombre inválido');
        }

        $playlistModel->update($id, ['name' => $newName]);
        return redirect()->to("/my-playlists/$id")->with('success', 'Playlist renombrada');
    }

    public function deletePlaylist($id)
    {
        $playlistModel = new PlaylistModel();
        $playlistModel->delete($id);
        return redirect()->to('/my-playlists')->with('success', 'Playlist eliminada');
    }

    public function addTrack($playlistId, $trackId)
    {
        $session = session();
        $userId = $session->get('user_id');
        if (!$userId) {
            return redirect()->to('/sign-in');
        }

        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->where('id', $playlistId)->where('user_id', $userId)->first();

        if (!$playlist) {
            return redirect()->back()->with('error', 'Playlist no encontrada o no pertenece al usuario.');
        }

        $trackModel = new TrackModel();
        $playlistTrackModel = new PlaylistTrackModel();

        $existingTrack = $trackModel->find($trackId);
        if (!$existingTrack) {
            $trackData = [
                'id'          => $trackId,
                'name'        => $this->request->getPost('track_name'),
                'cover'       => $this->request->getPost('cover'),
                'artist_id'   => $this->request->getPost('artist_id'),
                'artist_name' => $this->request->getPost('artist_name'),
                'album_id'    => $this->request->getPost('album_id'),
                'album_name'  => $this->request->getPost('album_name'),
                'duration'    => $this->request->getPost('duration'),
                'player_url'  => $this->request->getPost('audio_url'),
            ];
            $trackModel->insert($trackData);
        }

        $alreadyInPlaylist = $playlistTrackModel
            ->where('playlist_id', $playlistId)
            ->where('track_id', $trackId)
            ->first();

        if (!$alreadyInPlaylist) {
            $playlistTrackModel->insert([
                'playlist_id' => $playlistId,
                'track_id'    => $trackId
            ]);
        }

        return redirect()->back()->with('success', 'Pista agregada correctamente.');
    }

    public function deleteTrack($playlistId, $trackId)
    {
        $trackModel = new TrackModel();

        $trackModel->delete($trackId);

        return redirect()->to('my-playlists/' . $playlistId);

    }

    public function save()
    {
        $playlistName = $this->request->getPost('playlist_name');
        $playlistCover = $this->request->getPost('playlist_cover');
        $originalPlaylistId = $this->request->getPost('playlist_id');
        $userId = session()->get('user_id');

        $playlistModel = new PlaylistModel();
        $trackModel = new TrackModel();
        $playlistTrackModel = new PlaylistTrackModel();

        $newPlaylistId = $playlistModel->insert([
            'name'       => $playlistName,
            'cover'      => $playlistCover,
            'user_id'    => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $originalTracks = session()->get("public_playlist_tracks_$originalPlaylistId");

        if (!$originalTracks || !is_array($originalTracks)) {
            log_message('error', 'No tracks found in session for playlist ' . $originalPlaylistId);
            return redirect()->back()->with('error', 'No se pudieron obtener las pistas de la playlist.');
        }

        foreach ($originalTracks as $track) {
            if (!$trackModel->find($track['id'])) {
                $trackModel->insert([
                    'id'          => $track['id'],
                    'name'        => $track['name'] ?? null,
                    'cover'       => $track['album_image'] ?? null,
                    'artist_id'   => $track['artist_id'] ?? null,
                    'artist_name' => $track['artist_name'] ?? null,
                    'album_id'    => $track['album_id'] ?? null,
                    'album_name'  => $track['album_name'] ?? 'Unknown Album',
                    'duration'    => $track['duration'] ?? 0,
                    'player_url'  => $track['audio'] ?? null,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ]);
            }

            $playlistTrackModel->insert([
                'playlist_id' => $newPlaylistId,
                'track_id'    => $track['id'],
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('/my-playlists')->with('success', 'Playlist y canciones guardadas exitosamente.');
    }
}
