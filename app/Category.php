<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Torrent;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['id', 'parent_id', 'title'];
    public $timestamps = false;

    public function Torrent() {
    	return $this->belongsTo("App\Torrent");
    }

    public function Icon() {
    	if($this->id == 135) $icon = "<i class='fa fa-venus-mars'></i>";
    	if($this->id == 131) $icon = "<i class='fa fa-film'></i>";
    	if($this->id == 130) $icon = "<i class='fa fa-music'></i>";
    	if($this->id == 132) $icon = "<i class='fa fa-tv'></i>";
    	if($this->id == 133) $icon = "<i class='fa fa-cogs'></i>";
    	if($this->id == 134) $icon = "<i class='fa fa-gamepad'></i>";
    	if($this->id == 136) $icon = "<i class='fa fa-book'></i>";
    	if($this->id == 137) $icon = "<i class='fa fa-question-circle'></i>";
    	if(!isset($icon)) $icon = "<i class='fa fa-question-circle'></i>";
    	return $icon;

    }

}
