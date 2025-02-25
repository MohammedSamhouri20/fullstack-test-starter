<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "order_items")]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: AbstractProduct::class)]
    private AbstractProduct $product;

    #[ORM\Column(type: "integer")]
    private int $quantity;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "items")]
    private Order $order;

    public function __construct(AbstractProduct $product, int $quantity, Order $order)
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->order = $order;
    }
}
