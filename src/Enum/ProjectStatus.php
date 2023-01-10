<?php

declare(strict_types=1);

namespace App\Enum;
enum ProjectStatus: string
{
    case Research = 'research';
    case Development = 'development';
    case Testing = 'testing';
    case Released = 'released';
    case EndOfLife = 'eol';
    case OnIce = 'on-ice';
}
