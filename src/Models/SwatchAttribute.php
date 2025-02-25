<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "attributes")]
class SwatchAttribute extends AbstractAttribute
{
    public function getType(): string
    {
        return "swatch";
    }
}
