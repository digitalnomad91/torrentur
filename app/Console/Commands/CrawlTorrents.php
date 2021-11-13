<?php

namespace App\Console\Commands;

use App\Torrent;
use Illuminate\Console\Command;
use DB;

class CrawlTorrents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'torrent:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl torrent site(s) for torrents to add to DB';

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
     * @param string $url
     * @return array
     */
    public static function getRecentTorrents()
    {
        $url = 'https://thepiratebay.org/recent';
        $ret = [];
        $html = @file_get_contents($url);
        if (!$html) {
            return false;
        }
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);

        // grab all the on the page
        $xpath = new \DOMXPath($dom);
        $linksList = $xpath->evaluate("/html/body//a");

        foreach ($linksList as $link) {
            $url = $link->getAttribute('href');
            if (preg_match('/^\/torrent\//i', $url)) {
                $full_url = 'https://thepiratebay.org'.$url;
                $ret[] = Torrent::getTorrentDetails($full_url);
            }
        }

        return $ret;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $torrents = self::getRecentTorrents();
        foreach ($torrents as $torrent) {
            print_r("\n");
            print_r($torrent);
            print_r("\n");
            Torrent::Create($torrent);
        }
    }
}
