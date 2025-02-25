<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "attribute_items")]
class AttributeItem
{
    #[ORM\Id]
    #[ORM\Column(type: "string")]
    private string $id;

    #[ORM\Column(type: "string")]
    private string $displayValue;

    #[ORM\Column(type: "string")]
    private string $value;

    #[ORM\ManyToOne(targetEntity: AbstractAttribute::class, inversedBy: "items")]
    private AbstractAttribute $attribute;

    public function __construct(string $id, string $displayValue, string $value, AbstractAttribute $attribute)
    {
        $this->id = $id;
        $this->displayValue = $displayValue;
        $this->value = $value;
        $this->attribute = $attribute;
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
}
