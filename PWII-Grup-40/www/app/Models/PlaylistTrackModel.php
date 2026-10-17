<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaylistTrackModel extends Model
{
    protected $table = 'playlist_tracks';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['playlist_id', 'track_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
