<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\AbstractProduct;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function placeOrder(array $itemsInput): Order
    {
        $order = new Order();

        foreach ($itemsInput as $itemInput) {
            $productId = $itemInput['productId'] ?? null;
            $quantity = $itemInput['quantity'] ?? 1;
            $selectedAttributes = $itemInput['selectedAttributes'] ?? [];

            if ($productId === null || $quantity < 1) {
                throw new \InvalidArgumentException('Invalid product ID or quantity');
            }

            $product = $this->entityManager->getRepository(AbstractProduct::class)->find($productId);
            if (!$product) {
                throw new \RuntimeException("Product with ID $productId not found");
            }

            // Create the OrderItem and add it to the order
            $orderItem = new OrderItem($product, $quantity, $order, $selectedAttributes);
            $order->getItems()->add($orderItem);
        }

        // Update total price after all items have been added
        $order->updateTotalPrice();

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}
