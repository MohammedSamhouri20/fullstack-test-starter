<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\MappedSuperclass]
abstract class AbstractAttribute
{
    #[ORM\Id]
    #[ORM\Column(type: "string")]
    protected string $id;

    #[ORM\Column(type: "string")]
    protected string $name;

    #[ORM\ManyToOne(targetEntity: AbstractProduct::class, inversedBy: "attributes")]
    protected AbstractProduct $product;

    #[ORM\OneToMany(mappedBy: "attribute", targetEntity: AttributeItem::class, cascade: ["persist"])]
    protected $items;

    public function __construct(string $name, AbstractProduct $product)
    {
        $this->name = $name;
        $this->product = $product;
        $this->items = new ArrayCollection();
    }

    abstract public function getType(): string;
}
