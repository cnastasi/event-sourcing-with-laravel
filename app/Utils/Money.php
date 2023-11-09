<?php

namespace App\Utils;

class Money
{
    public static function toString(int $value): string
    {
        return number_format($value / 100, 2, ',', '.') . ' €';
    }

}
