<?php

namespace App\Controller;

use App\GraphQL\Schema;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
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
        // Set CORS headers at the very start
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit();
        }

        // Set response type for actual GraphQL queries
        header("Content-Type: application/json; charset=UTF-8");
        try {
            // Initialize services
            $productService = new ProductService($this->entityManager);
            $categoryService = new CategoryService($this->entityManager);
            $orderService = new OrderService($this->entityManager);

            // Build the schema
            $schemaConfig = Schema::build();

            // Create the schema
            $schema = new \GraphQL\Type\Schema($schemaConfig);

            // Read the input from the request
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            // Parse the input
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;

            // Execute the GraphQL query
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
            // Handle errors
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        // Return the response
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}
