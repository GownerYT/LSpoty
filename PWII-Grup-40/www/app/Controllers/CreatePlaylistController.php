<?php

namespace App\Controllers;
use App\Models\PlaylistModel;

class CreatePlaylistController extends BaseController
{
    public function index(): string
    {
        return view('create_playlist');
    }

    public function store()
    {
        $playlistModel = new PlaylistModel();

        $data = [
            'user_id' => session()->get('user_id'),
            'name' => $this->request->getPost('name'),
            'cover' => $this->request->getPost('cover') ?: base_url('uploads/img/defaultCover.png')
        ];

        $playlistModel->insert($data);

        return redirect()->to('/my-playlists');
    }
}
