<?php

namespace App\Mappers;

class AttributeItemMapper extends BaseMapper
{
    public static function map($data): array
    {
        return array_map(function ($AttributeItem) {
            return [
                'id' => $AttributeItem->getDisplayValue(),
                'displayValue' => $AttributeItem->getDisplayValue(),
                'value' => $AttributeItem->getValue(),
            ];
        }, $data);
    }
}
