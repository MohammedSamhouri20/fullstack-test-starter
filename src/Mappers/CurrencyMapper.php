<?php

namespace App\Mappers;

class CurrencyMapper extends BaseMapper
{
    public static function map($data): array
    {
        return [
            'label' => $data->getLabel(),
            'symbol' => $data->getSymbol(),
        ];
    }
}
