<?php

namespace App\Console\Commands;

use App\Torrent;
use Illuminate\Console\Command;

class ScrapeMissingMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:tpb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iterates over Torrents DB and scrapes missing metadata';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function FindTorrentsMissingMetadata() {
        return Torrent::where([["file_count", "=", 0],
                               ["torrent_url", "LIKE", "https://thepiratebay.org/torrent/%"]])->inRandomOrder()->simplePaginate(25);
    }

    public function UpdateTorrentsMissingMetadata($torrents) {

        foreach ($torrents as $torrent) {
            print_r("torrent_url = ".$torrent->torrent_url);
            print_r("\n");
            $torrent_arr = Torrent::getTorrentDetails($torrent->torrent_url);
            if(!$torrent_arr) {
                print_r("\n404?\n");
                $torrent->file_count = -1;
                $torrent->save();
            } else {
                print_r("\nFound!\n");
                print_r($torrent_arr);
                $torrent->title = $torrent_arr["title"];
                $torrent->seeders = $torrent_arr["seeders"];
                $torrent->leechers = $torrent_arr["leechers"];
                $torrent->size = $torrent_arr["size"];
                $torrent->file_count = $torrent_arr["file_count"];
                $torrent->description = $torrent_arr["description"];
                $torrent->category_id = $torrent_arr["category_id"];
                $torrent->snatched = $torrent_arr["snatched"];
                $torrent->created_at = \Carbon\Carbon::parse($torrent_arr["created_at"])->format('Y-m-d');
                $torrent->last_scraped = \Carbon\Carbon::now();
                $torrent->save();
                Torrent::setTrackerIds($torrent->id, $torrent_arr["tracker_urls"], $torrent_arr["info_hash"]);
                Torrent::setFileIds($torrent->id, $torrent_arr["file_list"]);
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {



/*
$client = new \Adrenth\Thetvdb\Client();
$client->setLanguage('nl');
// Obtain a token
$token = $client->authentication()->login("1D77F679D7BC9FE1", "digitalnomad91", "A7314CF567107182");
$client->setToken($token);
$client->authentication()->refreshToken();
$data = $client->search()->seriesByName('better call saul');
$data = $data->getData();
$series = $client->series()->get($data[0]->getId());
print_r($series)
return false;
*/

// Search Games by name
//$games = \Messerli90\IGDB\Facades\IGDB::getGame(9630);
//$games = \Messerli90\IGDB\Facades\IGDB::searchKeywords('fallout');
//print_r($games);
//return false;


/*
            $torrents = Torrent::select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id');
            //$torrents = $torrents->where("category_id", "=", "131");
            $torrents = $torrents->where("category_id", "=", "132");
            $torrents = $torrents->orderBy("id", "DESC")->simplePaginate (75);

            foreach($torrents as $torrent) {

                echo $torrent->title." - ".Torrent::titleToCategory($torrent->title)."\n";

$command = escapeshellcmd('parse-torrent-name/test.py "'.$torrent->title.'"');
$output = shell_exec($command);
$json = json_decode( $output );
print_r($json);
                //print_r(Torrent::GuessTitle($torrent->title));
                //echo Torrent::GuessTitle($torrent->title)." \n";

                echo "---------------------\n\n\n";
            }



        return;*/
        $torrents = self::FindTorrentsMissingMetadata();
        self::UpdateTorrentsMissingMetadata($torrents);
    }
}
