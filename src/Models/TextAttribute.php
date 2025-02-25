<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "attributes")]
class TextAttribute extends AbstractAttribute
{
    public function getType(): string
    {
        return "text";
    }
}
