<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class CategoryType
{
    public static function get(): ObjectType
    {
        return new ObjectType([
            'name' => 'Category',
            'fields' => [
                'name' => Type::string(),
            ],
            'resolveField' => function ($value, $args, $context, $info) {
                if ($info->fieldName === '__typename') {
                    return 'Category';
                }
                return $value[$info->fieldName] ?? null;
            },
        ]);
    }
}
