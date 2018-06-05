<?php

namespace App\Console\Commands;

use App\Trend;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TweetJoke extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '8081:twtjk {place_id} {trend_count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tweet a joke from query results.';

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
        // 直近と一日前のトレンドデータをDBから取得
        $createdFrom = (new Carbon(Carbon::now()->format('Y-m-d H:i') . ':00'))->subDay();

        $pastTrends = Trend::select('name')
            ->where('created_at', '>=', $createdFrom)
            ->where('place_id', $this->argument('place_id'))
            ->orderBy('created_at', 'asc')
            ->take($this->argument('trend_count'))
            ->get()
            ->pluck('name');

        $recentTrends = Trend::select('name')
            ->where('place_id', $this->argument('place_id'))
            ->orderBy('created_at', 'desc')
            ->take($this->argument('trend_count'))
            ->get()
            ->pluck('name');

        //　一日前/直近にあって直近/一日前にはないトレンドをランダムに1つ取得
        $sbjYare = $pastTrends->diff($recentTrends)->random();
        $sbjHai = $recentTrends->diff($pastTrends)->random();

        //　ツイート
        $twitter = \TwitterConnection::connect();
        $twitter->post(
            "statuses/update",
            array("status" => \Lang::get(
                'tweet_template.yare_hai',
                ['sbjYare' => $sbjYare, 'sbjHai' => $sbjHai]
            ))
        );
    }
}
