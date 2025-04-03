<?php

namespace App\GraphQL\Resolvers;

use App\Services\OrderService;
use GraphQL\Type\Definition\ResolveInfo;

class OrderResolver
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function resolvePlaceOrder($root, array $args, $context)
    {
        $items = $args['input']['items'] ?? [];
        $order = $this->orderService->placeOrder($items);
        return $order;
    }
}
