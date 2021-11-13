<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $table = 'trackers';
    protected $fillable = ['id', 'name', 'url'];
    public $timestamps = false;
}
