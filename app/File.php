<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	public function human_size($precision = 2) {
		$size = $this->size_bytes;
	    $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
	    $step = 1024;
	    $i = 0;
	    while (($size / $step) > 0.9) {
	        $size = $size / $step;
	        $i++;
	    }
	    return round($size, $precision).$units[$i];
	}
}
