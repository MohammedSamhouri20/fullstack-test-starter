<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "prices")]
class Price
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "float")]
    private float $amount;

    #[ORM\ManyToOne(targetEntity: Currency::class)]
    #[ORM\JoinColumn(name: "currency_label", referencedColumnName: "label", nullable: false)]
    private Currency $currency;

    #[ORM\ManyToOne(targetEntity: AbstractProduct::class, inversedBy: "prices", fetch: "EAGER")]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id", nullable: false)]
    private AbstractProduct $product;

    public function __construct(float $amount, Currency $currency, AbstractProduct $product)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->product = $product;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getProduct(): AbstractProduct
    {
        return $this->product;
    }
}
