<?php

namespace App\GraphQL\Resolvers;

use App\Models\Category;
use App\Services\CategoryService;
use Doctrine\ORM\EntityManagerInterface;

class CategoryResolver
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function resolveCategories(): array
    {
        return $this->categoryService->getAllCategories();
    }
}
