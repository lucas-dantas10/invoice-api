<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Number;

use function Laravel\Prompts\info;

class Playground extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info(Number::currency(3000, "BRL")); 
        info(Number::format(1000));
    }
}
