<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class AttributeSetType
{
    public static function get(): ObjectType
    {
        return new ObjectType([
            'name' => 'AttributeSet',
            'fields' => [
                'id' => Type::string(),
                'name' => Type::string(),
                'type' => Type::string(),
                'items' => Type::listOf(AttributeType::get()),
            ],
            'resolveField' => function ($value, $args, $context, $info) {
                if ($info->fieldName === '__typename') {
                    return 'AttributeSet';
                }
                return $value[$info->fieldName] ?? null;
            },
        ]);
    }
}
