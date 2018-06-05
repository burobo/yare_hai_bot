<?php

namespace App\Console\Commands;

use App\Trend;
use Illuminate\Console\Command;

class DeleteTrends extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '8081:deltrd {place_id} {time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old trends in a database.';

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
        Trend::where('place_id', $this->argument('place_id'))
            ->where('created_at', '<=', $this->argument('time'))
            ->delete();
    }
}
