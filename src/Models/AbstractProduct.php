<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "products")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["clothing" => ClothingProduct::class, "tech" => TechProduct::class])]
abstract class AbstractProduct
{
    #[ORM\Id]
    #[ORM\Column(type: "string", unique: true, length: 36)]
    protected string $id;

    #[ORM\Column(type: "string", length: 191)]
    protected string $name;

    #[ORM\Column(type: "boolean")]
    protected bool $inStock;

    #[ORM\Column(type: "text")]
    protected string $description;

    #[ORM\Column(type: "text")]
    protected string $brand;

    #[ORM\ManyToOne(targetEntity: Category::class, fetch: "EAGER")]
    #[ORM\JoinColumn(name: "category_id", referencedColumnName: "id", nullable: false)]
    protected Category $category;

    #[ORM\OneToMany(mappedBy: "product", targetEntity: Price::class, cascade: ["persist"], fetch: "EAGER")]
    protected Collection $prices;

    #[ORM\OneToMany(mappedBy: "product", targetEntity: AttributeItem::class, cascade: ["persist"], fetch: "EAGER")]
    protected Collection $attributeItems;

    #[ORM\Column(type: "text")]
    protected string $gallery;

    public function __construct(
        string $id,
        string $name,
        bool $inStock,
        string $description,
        Category $category,
        array $gallery,
        string $brand
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->category = $category;
        $this->prices = new ArrayCollection();
        $this->attributeItems = new ArrayCollection();
        $this->gallery = json_encode($gallery);
        $this->brand = $brand;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isInStock(): bool
    {
        return $this->inStock;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function getGallery(): array
    {
        return json_decode($this->gallery, true) ?? [];
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getAttributeItems(): Collection
    {
        return $this->attributeItems;
    }

    abstract public function getProductType(): string;
}
