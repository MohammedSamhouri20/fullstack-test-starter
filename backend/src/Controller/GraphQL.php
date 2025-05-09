<?php

namespace App\Controller;

use App\GraphQL\Schema;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\GraphQL as GraphQLBase;
use RuntimeException;
use Throwable;

class GraphQL
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit();
        }

        header("Content-Type: application/json; charset=UTF-8");
        try {
            $productService = new ProductService($this->entityManager);
            $categoryService = new CategoryService($this->entityManager);
            $orderService = new OrderService($this->entityManager);

            $schemaConfig = Schema::build();

            $schema = new \GraphQL\Type\Schema($schemaConfig);

            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;

            $result = GraphQLBase::executeQuery(
                $schema,
                $query,
                null,
                [
                    'productService' => $productService,
                    'categoryService' => $categoryService,
                    'orderService' => $orderService,
                ],
                $variableValues
            );

            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}
