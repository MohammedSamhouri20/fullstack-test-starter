<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class PriceType
{
    public static function get(): ObjectType
    {
        return new ObjectType([
            'name' => 'Price',
            'fields' => [
                'amount' => Type::float(),
                'currency' => CurrencyType::get(),
            ],
            'resolveField' => function ($value, $args, $context, $info) {
                if ($info->fieldName === '__typename') {
                    return 'Price';
                }
                return $value[$info->fieldName] ?? null;
            },
        ]);
    }
}
