<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "products")]
class ClothingProduct extends AbstractProduct
{
    public function getProductType(): string
    {
        return "clothing";
    }
}
