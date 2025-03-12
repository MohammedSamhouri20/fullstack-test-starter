<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType
{
    private static $instance = null;

    public static function get(): ObjectType
    {
        if (self::$instance === null) {
            self::$instance = new ObjectType([
                'name' => 'Attribute',
                'fields' => [
                    'id' => Type::string(),
                    'displayValue' => Type::string(),
                    'value' => Type::string(),
                ],
                'resolveField' => function ($value, $args, $context, $info) {
                    if ($info->fieldName === '__typename') {
                        return 'Attribute';
                    }
                    return $value[$info->fieldName] ?? null;
                },
            ]);
        }
        return self::$instance;
    }
}
