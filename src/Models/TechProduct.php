<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "products")]
class TechProduct extends AbstractProduct
{
    public function getProductType(): string
    {
        return "tech";
    }
}
