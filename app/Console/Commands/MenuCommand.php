<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl torrent site(s) for torrents to add to DB';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $option = $this->menu('Pizza menu', [
            'Freshly baked muffins',
            'Freshly baked croissants',
            'Turnovers, crumb cake, cinnamon buns, scones',
        ])->open();

        $this->info("You have chosen the option number #$option");
    }
}
