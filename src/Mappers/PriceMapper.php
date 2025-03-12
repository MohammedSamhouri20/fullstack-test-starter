<?php

namespace App\Mappers;

class PriceMapper extends BaseMapper
{
    public static function map($data): array
    {
        return array_map(function ($price) {
            return [
                'amount' => $price->getAmount(),
                'currency' => CurrencyMapper::map($price->getCurrency()),
            ];
        }, $data);
    }
}
