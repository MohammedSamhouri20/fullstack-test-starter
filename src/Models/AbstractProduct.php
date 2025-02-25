<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\MappedSuperclass]
abstract class AbstractProduct
{
    #[ORM\Id]
    #[ORM\Column(type: "string")]
    protected string $id;

    #[ORM\Column(type: "string")]
    protected string $name;

    #[ORM\Column(type: "boolean")]
    protected bool $inStock;

    #[ORM\Column(type: "text")]
    protected string $description;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    protected Category $category;

    #[ORM\OneToMany(mappedBy: "product", targetEntity: Price::class, cascade: ["persist"])]
    protected $prices;

    #[ORM\OneToMany(mappedBy: "product", targetEntity: AbstractAttribute::class, cascade: ["persist"])]
    protected $attributes;

    #[ORM\Column(type: "json")]
    protected array $gallery;

    public function __construct(
        string $id,
        string $name,
        bool $inStock,
        string $description,
        Category $category,
        array $gallery
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->category = $category;
        $this->prices = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->gallery = $gallery;
    }

    abstract public function getProductType(): string;
}
