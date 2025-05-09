<?php

namespace App\GraphQL\Types;

use App\Mappers\ProductMapper;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemType
{
    private static $instance = null;

    public static function get(): ObjectType
    {
        if (self::$instance === null) {
            self::$instance = new ObjectType([
                'name' => 'OrderItem',
                'fields' => [
                    'id' => Type::nonNull(Type::int()),
                    'product' => ProductType::get(),
                    'quantity' => Type::nonNull(Type::int()),
                    'selectedAttributes' => Type::nonNull(Type::listOf(Type::nonNull(Type::string()))),
                ],
                'resolveField' => function ($orderItem, $args, $context, $info) {
                    if ($info->fieldName === '__typename') {
                        return 'OrderItem';
                    }
                    switch ($info->fieldName) {
                        case 'id':
                            return $orderItem->getId();
                        case 'product':
                            return ProductMapper::mapSingle($orderItem->getProduct());
                        case 'quantity':
                            return $orderItem->getQuantity();
                        case 'selectedAttributes':
                            return json_decode($orderItem->getSelectedAttributes(), true);
                        default:
                            return null;
                    }
                },
            ]);
        }
        return self::$instance;
    }
}
