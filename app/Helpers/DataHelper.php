<?php 

namespace App\Helpers;

class DataHelper
{
    public static function filterNullValues(array $data): array
    {
        return array_filter($data, function ($value) {
            return !is_null($value);
        });
    }
}