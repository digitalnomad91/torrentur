<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function Index() {

echo "<pre>";
$torrents = self::getTorrents('https://thepiratebay.org/recent');
print_r($torrents);

die();
		return view("admin");
    }



    /**
     * @param string $url
     * @return array|bool
     */
    public static function getTorrents($url)
    {
        $urlList = [];
        $html = @file_get_contents($url);

        if (!$html) {
            return false;
        }
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);

        // grab all the on the page
        $xpath = new \DOMXPath($dom);
        $linksList = $xpath->evaluate("/html/body//a");
        $torrent_id = false;

        foreach ($linksList as $link) {
            $url = $link->getAttribute('href');
            if (preg_match('/^\/torrent\//i', $url)) {
                $torrent_id = explode('/', $url)[2];
                $urlList[$torrent_id]['id'] = $torrent_id;
                $urlList[$torrent_id]['url'] = 'https://thepiratebay.org'.$url;
            }

            if (preg_match('/magnet:\?xt=urn:btih:(?P<info_hash>\d+)&/i', $url, $matches)) {
                $urlList[$torrent_id]['info_hash'] = $matches['info_hash'];
                $urlList[$torrent_id]['magnet'] = $url;
                $urlList[$torrent_id]['description'] = urldecode(explode('&tr', explode('&dn=', $url)[1])[0]);
                $urlList[$torrent_id]['title'] = $urlList[$torrent_id]['description'];
            }

            $title = $link->getAttribute('title');
            if ($title == "Files") {
                $urlList[$torrent_id]['file_count'] = $title->nodeValue;
            }
        }

        if (preg_match("/\((?P<size>\d+)&nbsp;Bytes\)/i", $html, $matches)) {
            $urlList[$torrent_id]['size'] = $matches['size'];
        }

        if (preg_match("/Seeders:(.*)<dd>(?P<seeders>\d+)<\/dd>/i", $html, $matches)) {
            $urlList[$torrent_id]['seeders'] = $matches['seeders'];
        }

        if (preg_match("/Leechers:(.*)<dd>(?P<leechers>\d+)<\/dd>/i", $html, $matches)) {
            $urlList[$torrent_id]['leechers'] = $matches['leechers'];
        }

        return $urlList;
    }



} 

?>