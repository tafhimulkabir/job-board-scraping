<?php

declare(strict_types = 1);

namespace App\Enums;

enum JobStatusEnum: string
{
    case Open   = 'open';
    case Close  = 'close';

    public static function get(string $value): self | string
    {
        return match($value) {
            'open'      => self::Open,
            'close'     => self::Close,
            default     => 'Opps! Could not find any status!'
        };
    }

    public static function set(self $value): string
    {
        return match($value) {
            self::Open      => self::Open->value,
            self::Close     => self::Close->value,
            default     => 'Opps! Could not find any status value!'
        };
    }
}
