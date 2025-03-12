<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "attribute_items")]
class AttributeItem
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 36)]
    private string $id;

    #[ORM\Column(type: "string", length: 191)]
    private string $displayValue;

    #[ORM\Column(type: "string", length: 191)]
    private string $value;

    #[ORM\ManyToOne(targetEntity: AbstractAttribute::class, inversedBy: "items")]
    #[ORM\JoinColumn(nullable: false)]
    private AbstractAttribute $attribute;

    #[ORM\ManyToOne(targetEntity: AbstractProduct::class, inversedBy: "attributeItems")]
    #[ORM\JoinColumn(nullable: false)]
    private AbstractProduct $product;

    public function __construct(
        string $id,
        string $displayValue,
        string $value,
        AbstractAttribute $attribute,
        AbstractProduct $product
    ) {
        $this->id = $id;
        $this->displayValue = $displayValue;
        $this->value = $value;
        $this->attribute = $attribute;
        $this->product = $product;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getAttribute(): AbstractAttribute
    {
        return $this->attribute;
    }

    public function getProduct(): AbstractProduct
    {
        return $this->product;
    }
}
