<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TechProduct extends AbstractProduct
{
    public function getProductType(): string
    {
        return "tech";
    }
}
