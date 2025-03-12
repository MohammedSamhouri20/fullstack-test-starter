<?php

namespace App\Services;

use App\Mappers\ProductMapper;
use App\Models\AbstractProduct;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getProductsByFilters(array $filters = []): array
    {
        $repository = $this->entityManager->getRepository(AbstractProduct::class);
        $queryBuilder = $repository->createQueryBuilder('p');

        // Filter by id (assuming it's a single ID or an array of IDs)
        if (isset($filters['id'])) {
            if (is_array($filters['id'])) {
                $queryBuilder->andWhere('p.id IN (:ids)')
                    ->setParameter('ids', $filters['id']);
            } else {
                $queryBuilder->andWhere('p.id = :id')
                    ->setParameter('id', $filters['id']);
            }
        }

        // Filter by name (use LIKE to check if the name contains the words provided)
        if (isset($filters['name'])) {
            $queryBuilder->andWhere('p.name LIKE :name')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }
        if (isset($filters['inStock'])) {
            $queryBuilder->andWhere('p.inStock = :inStock')
                ->setParameter('inStock', $filters['inStock']);
        }
        // Filter by brand
        if (isset($filters['brand'])) {
            $queryBuilder->andWhere('p.brand = :brand')
                ->setParameter('brand', $filters['brand']);
        }

        // Filter by category
        if (isset($filters['category'])) {
            $queryBuilder->andWhere('p.category = :category')
                ->setParameter('category', $filters['category']);
        }

        $products = $queryBuilder->getQuery()->getResult();

        return ProductMapper::map($products);
    }
}
