<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class ProductType
{
    private static $instance = null;

    public static function get(): ObjectType
    {
        if (self::$instance === null) {
            self::$instance = new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::string(),
                    'name' => Type::string(),
                    'inStock' => Type::boolean(),
                    'gallery' => Type::listOf(Type::string()),
                    'description' => Type::string(),
                    'category' => Type::string(),
                    'attributes' => Type::listOf(AttributeSetType::get()),
                    'prices' => Type::listOf(PriceType::get()),
                    'brand' => Type::string(),
                ],
                'resolveField' => function ($value, $args, $context, $info) {
                    if ($info->fieldName === '__typename') {
                        return 'Product';
                    }
                    return $value[$info->fieldName] ?? null;
                },
            ]);
        }
        return self::$instance;
    }
}
