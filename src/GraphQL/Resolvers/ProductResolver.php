<?php

namespace App\GraphQL\Resolvers;

use App\Services\ProductService;

class ProductResolver
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function resolveProducts($root, $args, $context): array
    {
        return $this->productService->getProductsByFilters($args);
    }
}
