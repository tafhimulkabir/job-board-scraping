<?php

declare(strict_types = 1);

namespace App\Scraper;

class JobBoards
{
    public static function list(): array
    {
        return [
            'LaraJobBoardStrategy'              => 'https://larajobs.com/'
        ];
    }
}
