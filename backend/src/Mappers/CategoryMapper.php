<?php

namespace App\Mappers;

class CategoryMapper extends BaseMapper
{
    public static function map($data): array
    {
        return array_map(function ($category) {
            return [
                'name' => $category->getName(),
            ];
        }, $data);
    }
}
