<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlaylistTracksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'playlist_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'track_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('playlist_id', 'playlists', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('track_id', 'tracks', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('playlist_tracks');
    }

    public function down()
    {
        $this->forge->dropTable('playlist_tracks');
    }
}
