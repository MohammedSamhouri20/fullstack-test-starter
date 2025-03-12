<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ClothingProduct extends AbstractProduct
{
    public function getProductType(): string
    {
        return "clothing";
    }
}
