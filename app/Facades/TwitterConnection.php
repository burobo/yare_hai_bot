<?php
namespace App\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class TwitterConnection extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'twitter_connection';
    }
}
