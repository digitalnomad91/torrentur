<?php



function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) $bytes = number_format($bytes / 1073741824, 2) . ' GB';
	elseif ($bytes >= 1048576) $bytes = number_format($bytes / 1048576, 2) . ' MB';
	elseif ($bytes >= 1024) $bytes = number_format($bytes / 1024, 2) . ' KB';
	elseif ($bytes > 1) $bytes = $bytes . ' bytes';
	elseif ($bytes == 1) $bytes = $bytes . ' byte';
	else $bytes = '0 bytes';
    return $bytes;
}


function querystring_remove_var($url, $key) {
	$url = preg_replace('/(.*)(?|&)'. $key .'=[^&]+?(&)(.*)/i', '$1$2$4', $url .'&');
	$url = substr($url, 0, -1);
	return ($url);
}
