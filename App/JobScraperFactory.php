<?php

declare(strict_types = 1);

namespace App;

use Goutte\Client;

class JobScraperFactory
{
    const NAMESPACE = "App\Scraper\Jobs";

    private static function init(array $JobInfo, Client $client)
    {
        
    }
    
    public static function run(array $JobInfo, Client $client): array
    {
        return ['Test'];
    }
}
