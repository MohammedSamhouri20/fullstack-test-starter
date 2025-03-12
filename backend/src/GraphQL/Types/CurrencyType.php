<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class CurrencyType
{
    public static function get(): ObjectType
    {
        return new ObjectType([
            'name' => 'Currency',
            'fields' => [
                'label' => Type::string(),
                'symbol' => Type::string(),
            ],
            'resolveField' => function ($value, $args, $context, $info) {
                if ($info->fieldName === '__typename') {
                    return 'Currency';
                }
                return $value[$info->fieldName] ?? null;
            },
        ]);
    }
}
