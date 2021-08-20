<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;

class UpdateItemPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:update-item-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the item price mods';

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
     * @return int
     */
    public function handle()
    {
        Item::chunk(100, function ($items){
            foreach($items as $item){
                switch (rand(0,2)) {
                    case 0:
                        $item->value_mod = 0;
                        break;
                    case 1:
                        $item->value_mod = rand(-50, -1);
                        break;
                    case 2:
                        $item->value_mod = rand(1, 100);
                        break;
                }
                $item->save();
            }
        });
        return 0;
    }
}
