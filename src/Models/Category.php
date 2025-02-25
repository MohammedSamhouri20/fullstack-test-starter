<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: "categories")]
class Category
{
    #[ORM\Id]
    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\OneToMany(mappedBy: "category", targetEntity: AbstractProduct::class)]
    private $products;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->products = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
