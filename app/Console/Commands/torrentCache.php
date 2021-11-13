<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Torrent;
use DB;


class torrentCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'torrent:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command takes torrents from the disk storage db and dumps it into the RAM cache. This cache can then be queried quickly by the search engine and various other frontend/backend components.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $i = 0; $cont = true;
        while($cont) {
            if($i >= 100) break; //store a max of 250,000 in RAM


            $torrents = Torrent::where("id", ">=", "1")->orderBy("id", "DESC")->skip(($i * 1000))->take(1000)->get();
            foreach($torrents as $torrent) {
                echo $torrent->title."\n";
                 DB::table('torrents_cache')->where("info_hash", "=", $torrent->info_hash)->delete();


                DB::table('torrents_cache')->insert(
                    [
                        'id' => $torrent->id,
                        'category_id' => $torrent->category_id,
                        'user_id' => $torrent->user_id,
                        'title' => $torrent->title,
                        'category_guess' => $torrent->category_guess,
                        'title_guess' => $torrent->title_guess,
                        'description' => $torrent->description,
                        'views' => $torrent->views,
                        'info_hash' => $torrent->info_hash,
                        'seeders' => $torrent->seeders,
                        'leechers' => $torrent->leechers,
                        'size' => $torrent->size,
                        'snatched' => $torrent->snatched,
                        'file_count' => $torrent->file_count,
                        'torrent_url' => $torrent->torrent_url,
                        'last_scraped' => $torrent->last_scraped,
                        'created_at' => $torrent->created_at,
                        'updated_at' => $torrent->updated_at,
                        'episode' => $torrent->episode,
                        'season' => $torrent->season,
                        'quality' => $torrent->quality,
                    ]
                );

            }
            $i++;

            /* If there were torrents left then continue the loop */
            if($torrents) $cont = true;
                else $cont = false;
        }
    }
}
