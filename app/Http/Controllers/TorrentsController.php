<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Torrent;
use App\TorrentCache;

use App\TorrentFile;
use App\TorrentTracker;
use App\Tracker;
use DB;
use Carbon\Carbon;
use App\Providers\Scraper;

class TorrentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $Category = null)
    {

        if($Category) {
            if($Category == "xxx") $category_id = 135;
            if($Category == "movies") $category_id = 131;
            if($Category == "music") $category_id = 130;
            if($Category == "tv") $category_id = 132;
            if($Category == "software") $category_id = 133;
            if($Category == "games") $category_id = 134;
            if($Category == "ebooks") $category_id = 136;
            if($Category == "other") $category_id = 137;
        }
        $orderBy = $request->input("sortby");
        $order = ($request->input("sort") == "desc") ? "desc" : "asc";
        if($orderBy && $orderBy != "seeders" && $orderBy != "leechers" && $orderBy != "created_at" && $orderBy != "size") die("invalid sort by option.");


        /* If keyword in querystring then initiate search engine */
        if($request->input("keyword")) {

            /* Record searches in history (for search cloud) */
            $searchCloud = DB::table('search_history')->where('query', $request->input("keyword"))->first();
            if(!$searchCloud) {
                DB::table('search_history')->insertGetId(
                    [
                        'query' => $request->input("keyword"),
                        'hits'=> "1",
                        'last_searched'=>  date('Y-m-d H:i:s'),
                    ]
                );
            } else {
                DB::table('search_history')->where("id", "=", $searchCloud->id)->update(['last_searched' => date('Y-m-d H:i:s')]);
                DB::table('search_history')->where("id", "=", $searchCloud->id)->increment('hits');
            }

            $torrents = TorrentCache::remember(1800*30)->select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id');
            if($Category) $torrents->where("category_id", "=", "$category_id");
            $torrents = $torrents->where("title", "LIKE", "%".$request->input("keyword")."%");
            //$torrents = $torrents->orWhere("description", "LIKE", "%".$request->input("keyword")."%");
            if($orderBy) $torrents = $torrents->orderByRaw("$orderBy $order")->orderBy("id", "DESC")->simplePaginate (15);
                else $torrents = $torrents->orderByRaw("leechers DESC")->orderBy("id", "DESC")->simplePaginate (15);
            

            /* If nothing found in torrent RAM cache, then do a deeper search on the full disk DB */
            if(!$torrents) {
                $torrents = Torrent::remember(1800*30)->select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id');
                if($Category) $torrents->where("category_id", "=", "$category_id");
                $torrents = $torrents->where("title", "LIKE", "%".$request->input("keyword")."%");
                //$torrents = $torrents->orWhere("description", "LIKE", "%".$request->input("keyword")."%");
                if($orderBy) $torrents = $torrents->orderByRaw("$orderBy $order")->orderBy("id", "DESC")->simplePaginate (15);
                    else $torrents = $torrents->orderByRaw("leechers DESC")->orderBy("id", "DESC")->simplePaginate (15);
                
            }


        } else {
            $torrents = Torrent::select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id');
            if($Category) $torrents = $torrents->where("category_id", "=", "$category_id");
            if($orderBy) $torrents = $torrents->orderByRaw("$orderBy $order")->orderBy("id", "DESC")->simplePaginate (15);
                else $torrents = $torrents->orderBy("id", "DESC")->simplePaginate (15);
            
        }

        return view('torrents', [
            "category" => (isset($category_id) ? Category::find($category_id) : null),
            "torrents" => $torrents,
            "request" => $request
        ]);
    }


    public function searchAPI(Request $request) {
         $output = Array();


        $torrents = TorrentCache::remember(1800*30)->select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id');
        $torrents = $torrents->where("title", "LIKE", "%".$request->input("keyword")."%");
        //$torrents = $torrents->orWhere("description", "LIKE", "%".$request->input("keyword")."%");
        $torrents = $torrents->orderByRaw("leechers DESC")->orderBy("id", "DESC")->simplePaginate (15);

        /* If nothing found in torrent RAM cache, then do a deeper search on the full disk DB */
        if(!$torrents) {
            $torrents = Torrent::remember(1800*30)->select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id');
            if($Category) $torrents->where("category_id", "=", "$category_id");
            $torrents = $torrents->where("title", "LIKE", "%".$request->input("keyword")."%");
            //$torrents = $torrents->orWhere("description", "LIKE", "%".$request->input("keyword")."%");
            $torrents = $torrents->orderByRaw("leechers DESC")->orderBy("id", "DESC")->simplePaginate (15);
        }



         foreach($torrents as $res) {
        
            $output[] = Array("name"=>$res->title. " (".$res->title.")",  "icon"=>$res->category->icon());
         }
         if(count($output)) return response()->json($output); 
    }


    public function scrapeAPI($info_hash) {

        $torrent = Torrent::where("info_hash", "=", $info_hash)->first();
        if(!$torrent) return response()->json(["error"=>"Invalid info hash."]); 
        $info_hash = $torrent->info_hash;


        /* Get Trackers from Magnet Link */
        $url = $torrent->MagnetURI();
        if (preg_match('/magnet:\?xt=urn:btih:/i', $url)) {
            //$arr['magnet'] = $url;
            ////$arr['info_hash'] = urldecode(explode('&dn=', explode('xt=urn:btih:', $url)[1])[0]);
            //$arr['title'] = urldecode(explode('&tr', explode('&dn=', $url)[1])[0]);

            $undecoded_tracker_arr = explode("&tr=", explode("&tr=", $url, 2)[1]);
            $tracker_urls = array_map('urldecode', $undecoded_tracker_arr);
            $tracker_urls = $tracker_urls;
        }

        /* Get Scrape Info from array of tracker URL's. */
        $scraper = new Scraper();
        $info = $scraper->scrape(array($info_hash), $tracker_urls);

        print_r($info);
        die();
        if(($info)) {
            foreach($tracker_urls as $tracker) {
                $tracker = Tracker::where("url", "=", $tracker)->first();

                $torrent_tracker = TorrentTracker::where("tracker_id", "=", $tracker->id)->where("torrent_id", "=", $torrent->id)->first();
                $torrent_tracker->seeders = $info[$info_hash]['seeders'];
                $torrent_tracker->leechers = $info[$info_hash]['leechers'];
                $torrent_tracker->snatched = $info[$info_hash]['completed'];
                $torrent_tracker->updated_at = \Carbon\Carbon::now();
                $torrent_tracker->save();
            }
            $torrent->seeders = $info[$info_hash]['seeders'];
            $torrent->leechers = $info[$info_hash]['leechers'];
            $torrent->snatched = $info[$info_hash]['completed'];
            $torrent->last_scraped = \Carbon\Carbon::now();
            $torrent->save();

            return response()->json(["success"=>"true", "seeders"=>$torrent->seeders, "leechers"=>$torrent->leechers, "snatched"=>$torrent->snatched]); 
        } else {
            return response()->json(["error"=>"Could not scrape for peer data."]); 
        }

        



    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function Latest(Request $request)
    {


        $movies = Torrent::select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id')->where("category_id", "=", "131")->orderBy("id", "DESC")->simplePaginate (10);

        $tv = Torrent::select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id')->where("category_id", "=", "132")->orderBy("id", "DESC")->simplePaginate (10);

        $games = Torrent::select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id')->where("category_id", "=", "134")->orderBy("id", "DESC")->simplePaginate (10);

        $apps = Torrent::select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id')->where("category_id", "=", "133")->orderBy("id", "DESC")->simplePaginate (10);


        return view('recent', [
            "movies" => $movies,
            "tv" => $tv,
            "games" => $games,
            "apps" => $apps,
        ]);
    }


    public function Recent()
    {

        $categories = Category::where("id", ">=", "130")->where("id", "<=", "134")->orderByRaw("id = 131 DESC")->orderByRaw("id = 132 DESC")->orderByRaw("id = 134 DESC")->orderByRaw("id = 130 DESC")->orderByRaw("id = 133 DESC")->get();


        return view('recent', [
            "categories"=> $categories
        ]);  
    }

    public function Top($Category = null)
    {

        if($Category) {
            if($Category == "xxx") $category_id = 135;
            if($Category == "movies") $category_id = 131;
            if($Category == "music") $category_id = 130;
            if($Category == "tv") $category_id = 132;
            if($Category == "software") $category_id = 133;
            if($Category == "games") $category_id = 134;
            if($Category == "ebooks") $category_id = 136;
            if($Category == "other") $category_id = 137;
        }


        $date = new \Carbon\Carbon;
        $date->subWeek();

        $torrents = Torrent::remember(1800)->select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id');
        if($Category) $torrents->where("category_id", "=", "$category_id");
        $torrents = $torrents->orderByRaw("seeders DESC, id DESC")->simplePaginate (100);


        return view('top', [
            "torrents"=> $torrents,
            "category"=> (isset($category_id) ? Category::find($category_id) : null)
        ]);  
    }


    public function Read($id) {
        $torrent = Torrent::where("id", "=", $id)->first();
        if(!isset($torrent->id)) return response()->json(['error' => 'Torrent not found.']);

        $torrent_trackers = TorrentTracker::where("torrent_id", "=", $id)->get();
        $files = TorrentFile::where("torrent_id", "=", $id)->get();
        $category = Category::where("id", "=", $torrent->category_id)->first();
        
        if(!isset($category->title)) {
            $category = new \stdClass();
            $category->title = "Unknown";
        }

        $trackers = [];
        foreach($torrent_trackers as $torrent_tracker)
        {
            $trackers[] = Tracker::where("id", "=", $torrent_tracker->tracker_id)->first();
        }

        return view("torrentdetails", [
            "torrent" => $torrent, 
            "trackers" => $trackers,
            "files" => $files,
            "category" => $category,
        ]);
    }

    public function Edit($id) {
        $torrent = Torrent::where("id", "=", $id)->first();
        if(!isset($torrent->id)) return response()->json(['error' => 'Torrent not found.']);

        return view("torrentedit", [
            "torrent" => $torrent, 
        ]);
    }

    public function Update(Request $request) {
        $torrent = Torrent::find($request->input("id"));
        $torrent->torrent_url = $input("torrent_url");
        $torrent->title = $input("title");
        $torrent->description = $input("description");
        $torrent->category_id = $input("category_id");
        $torrent->save();

        return view("torrentedit", [
            "torrent" => $torrent, 
        ]);
    }

}

