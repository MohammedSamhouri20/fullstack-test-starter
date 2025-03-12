<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TextAttribute extends AbstractAttribute
{
    public function getType(): string
    {
        return "text";
    }
}
