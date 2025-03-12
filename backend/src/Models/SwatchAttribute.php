<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class SwatchAttribute extends AbstractAttribute
{
    public function getType(): string
    {
        return "swatch";
    }
}
