<?php

namespace App\GraphQL\Resolvers;

use App\Services\AttributeService;

class AttributeResolver
{
    private $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function resolveAttributes($root, $args, $context): array
    {
        return $this->attributeService->getAttributesForProduct($root['id']);
    }
}
