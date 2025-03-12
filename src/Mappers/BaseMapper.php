<?php

namespace App\Mappers;

abstract class BaseMapper
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public static function map(mixed $data): mixed
    {
        return $data;
    }
}
