<?php

namespace App\Machine\Entity;

class Candy
{
    public function __construct(
        private string $type,
        private float $price,
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}