<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TorrentTracker extends Model
{
    protected $table = 'torrent_trackers';
    protected $fillable = ['torrent_id', 'tracker_id'];
    public $timestamps = false;
}
