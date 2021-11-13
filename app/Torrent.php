<?php

namespace App;

use App\Category;
use App\Tracker;
use App\TorrentTracker;
use Illuminate\Database\Eloquent\Model;
use App\Providers\Scraper;
use Watson\Rememberable\Rememberable;


class Torrent extends Model
{
    protected $table = 'torrents';
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


    function Scrape($torrent) {

    }

    /** Takes a URL and array and returns an updated array
     * @param string $url
     * @param array
     * @return array
     */
    public static function getTorrentDetails($url)
    {
        // assumes given URL is of the form https://tpb.org/torrent/<torrent_id>/blah
        $torrent_id = explode('/', $url)[4];
        $arr = array();
        print_r("torrent_id = ".$torrent_id."\n");
        $arr['id'] = $torrent_id;
        $arr['url'] = $url;

        $html = @file_get_contents($url);

        if (!$html) {
            echo "NO HTML FOUND";
            return false;
        }
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);
        $linksList = $xpath->evaluate("/html/body//a");
        if(!isset($xpath->evaluate("//pre")[0]->nodeValue)) {
            echo "NO PRE??";
            return false;
        }

        foreach ($linksList as $link) {
            $url = $link->getAttribute('href');
            if (preg_match('/magnet:\?xt=urn:btih:/i', $url)) {
                $arr['magnet'] = $url;
                $arr['info_hash'] = urldecode(explode('&dn=', explode('xt=urn:btih:', $url)[1])[0]);
                $arr['title'] = urldecode(explode('&tr', explode('&dn=', $url)[1])[0]);

                $undecoded_tracker_arr = explode("&tr=", explode("&tr=", $url, 2)[1]);
                $tracker_urls = array_map('urldecode', $undecoded_tracker_arr);
                $arr['tracker_urls'] = $tracker_urls;
            }
            $title = $link->getAttribute('title');
            if ($title == "Files") {
                $arr['file_count'] = $link->nodeValue;
                $url_file_prefix = "https://thepiratebay.org/ajax_details_filelist.php?id=";
                $file_list_html = @file_get_contents($url_file_prefix.$torrent_id);
                $dom_files = new \DOMDocument;
                @$dom_files->loadHTML($file_list_html);

                $xpath_files = new \DOMXPath($dom_files);
                $trList = $xpath_files->evaluate("//tr");
                $file_list = [];
                foreach ($trList as $tr) {
                    $fname = $tr->firstChild->nodeValue;
                    $fsize = self::convertToBytes($tr->lastChild->nodeValue);
                    $file_list[$fname] = $fsize;
                }
                $arr["file_list"] = $file_list;
            }
            if ($title == "More from this category") {
                $category_str = $link->nodeValue;

                $music_cats = Array('Audio > Music', 'Audio > Audio books', 'Audio > Sound clips', 'Audio > FLAC', 'Audio > Other'); 
                $movie_cats = Array('Video > Movies', 'Video > Movies DVDR', 'Video > Music videos', 'Video > Movie clips', 'Video > HD - Movies');
                $tv_cats = Array('Video > TV shows', 'Video > HD - TV shows');
                $app_cats = Array('Applications > Windows', 'Applications > Mac', 'Applications > UNIX', 'Applications > Handheld', 'Applications > IOS (iPad/iPhone)', 'Applications > Android', 'Applications > Other OS');
                $game_cats = Array('Games > PC', 'Games > Mac', 'Games > PSx', 'Games > XBOX360', 'Games > Wii',  'Games > Handhex', 'Games > IOS (iPad/iPhone)', 'Games > Android', 'Games > Other');
                $xxx_cats = Array('Porn > Movies', 'Porn > Movies DVDR', 'Porn > Pictures', 'Porn > Games', 'Porn > HD - Movies', 'Porn > Movie clips', 'Porn > Other');
                $ebook_cat = Array('Other > E-books');


                $cat_id = 137; //other cat
                if(in_array(strtolower($category_str), array_map('strtolower', $music_cats))) $cat_id = 130;
                if(in_array(strtolower($category_str), array_map('strtolower', $movie_cats))) $cat_id = 131;
                if(in_array(strtolower($category_str), array_map('strtolower', $tv_cats))) $cat_id = 132;
                if(in_array(strtolower($category_str), array_map('strtolower', $app_cats))) $cat_id = 133;
                if(in_array(strtolower($category_str), array_map('strtolower', $game_cats))) $cat_id = 134;
                if(in_array(strtolower($category_str), array_map('strtolower', $xxx_cats))) $cat_id = 135;
                if(in_array(strtolower($category_str), array_map('strtolower', $ebook_cat))) $cat_id = 136;


                //$category_arr = array_reverse(explode(" > ", $category_str));
                $arr['category_id'] = $cat_id; //self::guessCategoryID($category_arr);
            }
        }

        $dtList = $xpath->evaluate("//dl/dt");
        foreach ($dtList as $dt) {
            // XXX commented out because I'm using Scrapeer to get this data now.
            // if ($dt->nodeValue == "Seeders:") { 
            //     $arr['seeders'] = $dt->nextSibling->nextSibling->nodeValue;
            // }

            // if ($dt->nodeValue == "Leechers:") {
            //     $arr['leechers'] = $dt->nextSibling->nextSibling->nodeValue;
            // }

            if ($dt->nodeValue == "Size:") {
                $sizestr = $dt->nextSibling->nextSibling->nodeValue;
                $arr['size'] = intVal(explode('(', $sizestr)[1]);
            }

            if ($dt->nodeValue == "Uploaded:") {
                $time_str = $dt->nextSibling->nextSibling->nodeValue;
                print_r("\ntime_str = ".$time_str."\n");
                $arr['created_at'] = $time_str;
            }

        }

        $arr['description'] = $xpath->evaluate("//pre")[0]->nodeValue;


        $scraper = new Scraper();
        $info = $scraper->scrape(array($arr['info_hash']), $arr['tracker_urls'] );
        if (!empty($info)) {
            $arr['seeders'] = $info[$arr['info_hash']]['seeders'];
            $arr['leechers'] = $info[$arr['info_hash']]['leechers'];
            $arr['snatched'] = $info[$arr['info_hash']]['completed'];
        } else {
            $arr['seeders'] = 0;
            $arr['leechers'] = 0;
            $arr['snatched'] = 0;
        }

        return $arr;
    }

    public static function Create($input)
    {
        $torrent = new Torrent;
        $torrent->torrent_url = $input["url"];
        $torrent->info_hash = $input["info_hash"];
        $torrent->title = $input["title"];

        /* Parse torrent title intelligently */
        $parseTitle = Torrent::parseTitleString($input["title"]);
        if(isset($parseTitle->title)) {
            $torrent->title_guess = $parseTitle->title;
            if(isset($parseTitle->season)) $torrent->season = $parseTitle->season;
            if(isset($parseTitle->episode)) $torrent->episode = $parseTitle->episode;
            if(isset($parseTitle->group)) $torrent->rls_group = $parseTitle->group;
            if(isset($parseTitle->codec)) $torrent->codec = $parseTitle->codec;
            if(isset($parseTitle->quality)) $torrent->quality = $parseTitle->quality;
            if(isset($parseTitle->resolution)) $torrent->resolution = $parseTitle->resolution;
            if(isset($parseTitle->excess)) $torrent->excess = implode(";", (array)$parseTitle->excess);
            if(isset($parseTitle->audio)) $torrent->audio = $parseTitle->audio;
            if(isset($parseTitle->year)) $torrent->year = $parseTitle->year;
        }

        $torrent->category_guess = Torrent::titleToCategory($input["title"]);+
        $torrent->seeders = $input["seeders"];
        $torrent->leechers = $input["leechers"];
        $torrent->size = $input["size"];
        $torrent->file_count = $input["file_count"];
        $torrent->description = $input["description"];
        $torrent->category_id = $input["category_id"];
        $torrent->snatched = $input["snatched"];
        //$torrent->created_at = (isset($input["created_at"]) ? $input["created_at"] : \Carbon\Carbon::now());
        $torrent->last_scraped = \Carbon\Carbon::now();
        $torrent->save();
        self::setTrackerIds($torrent->id, $input["tracker_urls"], $input["info_hash"]);
        self::setFileIds($torrent->id, $input["file_list"]);
    } 

    static function  parseTitleString($title) {
        $command = escapeshellcmd('parse-torrent-name/test.py "'.$title.'"');
        $output = shell_exec($command);
        $json = json_decode( $output );
        return $json;
    }

    public static function guessCategoryID($category_arr)
    {
        foreach ($category_arr as $category_str) {
            $category = Category::whereRaw("UPPER(`title`) LIKE ?", # XXX unsure if I should use LIKE or = here
                                              array(strtoupper($category_str)))->get();
            if (count($category) > 0) {
                return $category[0]->id;
            }
        }
        return 97; # Other category
    }

    public static function setTrackerIds($torrent_id, $url_arr, $info_hash)
    {
        foreach ($url_arr as $url) {
            $tracker = Tracker::where("url", "=", $url)->get();
            $torrent_tracker = new TorrentTracker;
            $torrent_tracker->torrent_id = $torrent_id;
            if (count($tracker) > 0) {
                $torrent_tracker->tracker_id = $tracker[0]->id;
            } else {
                $new_tracker = new Tracker;
                $new_tracker->url = $url;
                $new_tracker->save();
                $torrent_tracker->tracker_id = $new_tracker->id;
            }

            $scraper = new Scraper();
            $info = $scraper->scrape(array($info_hash), array($url));
            if(!empty($info)) {
                $torrent_tracker->seeders = $info[$info_hash]['seeders'];
                $torrent_tracker->leechers = $info[$info_hash]['leechers'];
                $torrent_tracker->snatched = $info[$info_hash]['completed'];
            }
            $torrent_tracker->updated_at = \Carbon\Carbon::now();
            $torrent_tracker->save();
        }
    }

    # not exact due to nature of data and truncation into integer
    public static function convertToBytes($from)
    {
        $number = substr($from, 0, -3);
        switch (substr($from, -3)) {
            case "KiB":
                return $number * 1024;
            case "MiB":
                return $number * pow(1024, 2);
            case "GiB":
                return $number * pow(1024, 3);
            case "TiB":
                return $number * pow(1024, 4);
            default:
                return $number;
        }
    }

    public static function setFileIds($torrent_id, $file_arr)
    {
        foreach ($file_arr as $filename => $filesize) {
            $file = new TorrentFile;
            $file->torrent_id = $torrent_id;
            $file->name = $filename;
            $file->size = $filesize;
            $file->save();
        }
    }

    static function getQuality($string)
    {
        if (strpos($string, '720') !== false) {
            return "720p";
        } else if (strpos($string, '1080') !== false) {
            return "1080p";
        } else if (strpos($string, 'HDTV') !== false) {
            return "HDTV";
        } else {
            return "Unknown";
        }
    }

    // Cleans up scene release torrent title    
    static function GuessTitle($input) {
        $input = strtolower($input);
        $exclude = array("docu", "xvid","divx","x264","bluray","blu-ray","dvdscr","aac","dvdrip","bdrip","brrip","hdtv","hdrip","ntsc","dvd","1080p","720p","480p",".mkv",".avi","mp3","flac",".","ac3","r5", "tpb", "avi", "torrent", "cam","ts","cd","ptv","vtv","tv","hd","scr","hq", "remastered", ")", "(");
        $output = "";

        $catGuess = Torrent::titleToCategory($input);
        $pattern       = "/(.*)\\.S?(\\d{1,2})E?(\\d{2})\\.(.*)/";
        $currentSeason = 0;

        //$input = str_replace('-', ' ', $input);
        //$torrentTitle = preg_replace('/\s+/', '.', $input);

        preg_match($pattern, $input, $matches);
        if(isset($matches[1])) {
            $torrentTitle = str_replace('.', ' ', $matches[1]);
            $quality = Torrent::getQuality($matches[4]);
        } else {
            $torrentTitle = str_replace('.', ' ', $input);
            $quality = Torrent::getQuality($torrentTitle);
        }

        
        if($catGuess == "TV" & isset($matches[2]) && isset($matches[3])) {
            $season    = $matches[2];
            $seasonint = (int) ltrim($season, '0');
            if ($seasonint > $currentSeason) {
                $currentSeason = $seasonint;
            }
            $episode = $matches[3];
            $ret["season"] = $season;
            $ret["episode"] = $episode;
        }
        

        $ret["category"] = $catGuess;
        $ret["quality"] = $quality;
        $ret["title"] = $torrentTitle;
        return $ret;

        if(strstr($input, "-")) $output = strtok($input, '-'); //get rid of everything after - (usually rls group)
        if(strstr($output, "r5")) $output = strtok($output, 'r5'); //if r5 then get wid of it & everything after (not part of title)
        //$output = preg_replace("/\b\d{4}\b/", "", $output);
        
        // Generate strings like 'S01', 'S02', 'E01', 'E02', etc. and places them into the $exclude array
        $i = 0;
        while( $i < 35 ) {
            if( $i < 10 ) {
                array_push($exclude,"S0".strval($i));
                array_push($exclude,"E0".strval($i));
            }else {
                array_push($exclude,"S".strval($i));
                array_push($exclude,"E".strval($i));
            }
            $i++;
        }


        /*$output = preg_replace_callback(
            "/\b(".implode("|",array_keys($exclude)).")\b/i",
            function($matchingPharse) use ($exclude) {
                return strtolower($exclude[strtolower($matchingPharse[0])]);
            },
            $output
        );*/
        ///$output = str_ireplace($exclude, " ", $output); // Excludes the list, $exclude, which is generated above    
        
        //$output = str_replace("%", "\\%", $output);
        //$output = str_replace("_", "\\_", $output);


        $output = str_replace("_"," ",trim($output)); //replace underscores with spaces
        $output = str_replace("  "," ",trim($output)); //remove double spaces with single space
        
        //if year detected, remove everything after year
        
        if (preg_match('/\b\d{4}\b/', $output, $matches)) {
            $year = $matches[0];
            $arr = explode($year, $output);
            $output = trim($arr[0]);
        }
        
        return $output;
    }

    // Title of a torrent -> Category
    // A category can be one of the following: TV, Movies, Applications, Music
    static function titleToCategory($input) {
    
        $input = strtolower($input);
        $musicArr = array("discography","cdr","mp3","flac","cd");
        $tvArr = array("tv","e0","s0","s1","e1");
        $movieArr = array("dvd","bdrip","brrip","bluray","mkv","avi","mp4","wmv", "xvid");
        $appArr = array("x32","x64");

        foreach($movieArr as $val) {
            if(substr_count($input,$val) > 0)
             return "Movie";
        }
        
        foreach($musicArr as $val){
            if(substr_count($input,$val) > 0)
               return "Music";
        }
        
            
        foreach($tvArr as $val) {
            if(substr_count($input,$val) > 0)
                return "TV";
        }
          

        foreach($appArr as $val){
            if(substr_count($input,$val) > 0)
               return "Application";
        }
        
        return "Other";
     }

}
