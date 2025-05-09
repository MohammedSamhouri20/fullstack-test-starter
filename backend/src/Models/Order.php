<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "orders")]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "datetime")]
    private \DateTime $createdAt;

    #[ORM\OneToMany(mappedBy: "order", targetEntity: OrderItem::class, cascade: ["persist"])]
    private $items;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $totalPrice;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->items = new ArrayCollection();
        $this->totalPrice = 0.00;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function updateTotalPrice(): void
    {
        $total = 0.00;
        foreach ($this->items as $item) {
            $prices = $item->getProduct()->getPrices()->toArray();
            if (!empty($prices)) {
                $price = $prices[0]->getAmount();
                $total += $item->getQuantity() * $price;
            }
        }
        $this->totalPrice = round($total, 2);
    }
}
