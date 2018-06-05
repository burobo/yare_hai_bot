<?php

namespace App\Console\Commands;

use App\Trend;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InsertTrends extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '8081:instrd {place_id} {trend_count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get twitter trends and save them.';

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
        // TwitterAPIからトレンド情報を取得する
        $twitter = \TwitterConnection::connect();
        $apiResult = json_decode(
            $twitter->OAuthRequest(
                "https://api.twitter.com/1.1/trends/place.json",
                "GET",
                ["id" => $this->argument('place_id')]
            ),
            true
        );

        // 取得したトレンド情報をDBに挿入
        $now = Carbon::now();
        $trends = [];

        for ($idx = 0; $idx < $this->argument('trend_count'); $idx++) {
            array_push($trends, [
                'name' => $apiResult[0]['trends'][$idx]['name'],
                'place_id' => $this->argument('place_id'),
                'created_at' => $now,
            ]);
        }

        Trend::insert($trends);
    }
}
