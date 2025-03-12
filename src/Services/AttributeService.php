<?php

namespace App\Services;

use App\Models\AbstractProduct;
use Doctrine\ORM\EntityManagerInterface;

class AttributeService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAttributesForProduct(string $productId): array
    {
        $product = $this->entityManager->getRepository(AbstractProduct::class)->find($productId);

        return $product->getAttributeItems()->toArray();
    }
}
