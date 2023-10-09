<?php

declare(strict_types = 1);

namespace App\Scraper\Jobs;

use Goutte\Client;
use APP\Scraper\JobBoardStrategy;
use App\Interfaces\JobScraperInterface;

class LaraJobBoardStrategy extends JobBoardStrategy //implements JobScraperInterface
{
    public function __construct(array $JobInfo, Client $client)
    {

    }

    public function scraper(): void
    {
        
    }
}
