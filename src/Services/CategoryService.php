<?php

namespace App\Services;

use App\Mappers\CategoryMapper;
use App\Models\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllCategories(): array
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        return CategoryMapper::map($categories);
    }
}
