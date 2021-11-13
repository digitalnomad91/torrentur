<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TorrentFile extends Model
{
    protected $table = 'torrent_files';
    protected $fillable = ['id', 'torrent_id', 'name', 'size'];
    public $timestamps = false;
}