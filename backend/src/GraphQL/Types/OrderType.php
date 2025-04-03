<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderType
{
    private static $instance = null;

    public static function get(): ObjectType
    {
        if (self::$instance === null) {
            self::$instance = new ObjectType([
                'name' => 'Order',
                'fields' => [
                    'id' => Type::nonNull(Type::int()),
                    'createdAt' => Type::nonNull(Type::string()),
                    'totalPrice' => Type::nonNull(Type::float()),  // Add the totalPrice field
                    'items' => Type::listOf(OrderItemType::get()),
                ],
                'resolveField' => function ($order, $args, $context, $info) {
                    if ($info->fieldName === '__typename') {
                        return 'Order';
                    }
                    switch ($info->fieldName) {
                        case 'id':
                            return $order->getId();
                        case 'createdAt':
                            return $order->getCreatedAt()->format('c'); // ISO 8601 format
                        case 'totalPrice': // Resolver for totalPrice
                            return $order->getTotalPrice();
                        case 'items':
                            return $order->getItems()->toArray();
                        default:
                            return null;
                    }
                },
            ]);
        }
        return self::$instance;
    }
}
