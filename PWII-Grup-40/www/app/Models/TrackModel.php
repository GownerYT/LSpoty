<?php

namespace App\Models;

use CodeIgniter\Model;

class TrackModel extends Model
{
    protected $table = 'tracks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id',
        'name',
        'cover',
        'artist_id',
        'artist_name',
        'album_id',
        'album_name',
        'duration',
        'player_url',
        'playlist_id',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}
