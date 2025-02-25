<?php

namespace App\Scandiweb\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "currencies")]
class Currency
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 3)]
    private string $label;  // e.g., "USD", "EUR"

    #[ORM\Column(type: "string", length: 5)]
    private string $symbol; // e.g., "$", "€"

    public function __construct(string $label, string $symbol)
    {
        $this->label = $label;
        $this->symbol = $symbol;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
