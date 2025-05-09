<?php

namespace App\GraphQL;

use App\GraphQL\Resolvers\CategoryResolver;
use App\GraphQL\Resolvers\OrderResolver;
use App\GraphQL\Resolvers\ProductResolver;
use App\GraphQL\Types\CategoryType;
use App\GraphQL\Types\OrderType;
use App\GraphQL\Types\ProductType;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Schema
{
    public static function build(): array
    {
        $orderItemInputType = new InputObjectType([
            'name' => 'OrderItemInput',
            'fields' => [
                'productId' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The ID of the product',
                ],
                'quantity' => [
                    'type' => Type::nonNull(Type::int()),
                    'description' => 'The quantity of the product',
                ],
                'selectedAttributes' => [
                    'type' => Type::nonNull(Type::listOf(new InputObjectType([
                        'name' => 'AttributeInput',
                        'fields' => [
                            'key' => [
                                'type' => Type::nonNull(Type::string()),
                                'description' => 'The attribute name',
                            ],
                            'value' => [
                                'type' => Type::nonNull(Type::string()),
                                'description' => 'The attribute value',
                            ],
                        ],
                    ]))),
                    'description' => 'The selected attributes for the product',
                ],
            ],
        ]);

        $orderInputType = new InputObjectType([
            'name' => 'OrderInput',
            'fields' => [
                'items' => [
                    'type' => Type::nonNull(Type::listOf($orderItemInputType)),
                    'description' => 'List of items in the order',
                ],
            ],
        ]);

        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(CategoryType::get()),
                    'resolve' => function ($root, $args, $context) {
                        $categoryResolver = new CategoryResolver($context['categoryService']);
                        return $categoryResolver->resolveCategories();
                    },
                ],
                'products' => [
                    'type' => Type::listOf(ProductType::get()),
                    'args' => [
                        'id' => ['type' => Type::string()],
                        'name' => ['type' => Type::string()],
                        'brand' => ['type' => Type::string()],
                        'category' => ['type' => Type::string()],
                        'inStock' => ['type' => Type::boolean()],
                    ],
                    'resolve' => function ($root, $args, $context) {
                        $productResolver = new ProductResolver($context['productService']);
                        return $productResolver->resolveProducts($root, $args, $context);
                    },
                ],
            ],
        ]);

        $mutationType = new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'placeOrder' => [
                    'type' => OrderType::get(),
                    'args' => [
                        'input' => [
                            'type' => $orderInputType,
                        ],
                    ],
                    'resolve' => function ($root, $args, $context) {
                        $orderResolver = new OrderResolver($context['orderService']);
                        return $orderResolver->resolvePlaceOrder($root, $args, $context);
                    },
                ],
            ],
        ]);

        return [
            'query' => $queryType,
            'mutation' => $mutationType,
        ];
    }
}
