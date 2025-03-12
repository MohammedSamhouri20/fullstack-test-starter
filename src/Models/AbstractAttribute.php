<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "attribute_set")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["swatch" => SwatchAttribute::class, "text" => TextAttribute::class])]
abstract class AbstractAttribute
{
    #[ORM\Id]
    #[ORM\Column(type: "string", unique: true, length: 36)]
    protected string $id;

    #[ORM\Column(type: "string", length: 191)]
    protected string $name;

    #[ORM\OneToMany(mappedBy: "attribute", targetEntity: AttributeItem::class, cascade: ["persist"])]
    protected Collection $items;


    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->items = new ArrayCollection();
    }

    abstract public function getType(): string;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }
}
