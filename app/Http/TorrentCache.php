<?php

namespace App;

use App\Category;
use App\Tracker;
use App\TorrentTracker;
use Illuminate\Database\Eloquent\Model;
use App\Providers\Scraper;
use Watson\Rememberable\Rememberable;


class TorrentCache extends Model
{
    protected $table = 'torrents_cache';
    protected $fillable = ['torrent_url', 'info_hash', 'title', 'description', 'size',
                           'file_count', 'seeders', 'leechers', 'file_list', 'description',
                           'category_id', 'tracker_id_  csv'];
    public $timestamps = true;
    use Rememberable;

    public function Category() {
        return $this->belongsTo('App\Category');
    }

    public function Trackers() {
        return $this->hasMany('App\TorrentTracker');
    }

    public function MagnetURI(){ 
        return"magnet:?xt=urn:btih:".$this->info_hash."&dn=".urlencode($this->title)."&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969&tr=udp%3A%2F%2Fzer0day.ch%3A1337&tr=udp%3A%2F%2Fopen.demonii.com%3A1337&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969&tr=udp%3A%2F%2Fexodus.desync.com%3A6969";
    }

    public function Slug() {
        $slug = str_replace(".", " ", $this->title);
        $ret = str_slug($slug, "-");
        return $ret;
    }


}
