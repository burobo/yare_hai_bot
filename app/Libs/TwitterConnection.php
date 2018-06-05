<?php
namespace App\Libs;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterConnection
{
    public function connect()
    {
        return new TwitterOAuth(
            env('API_KEY'),
            env('API_SECRET'),
            env('ACCESS_TOKEN'),
            env('ACCESS_TOKEN_SECRET')
        );
    }
}
