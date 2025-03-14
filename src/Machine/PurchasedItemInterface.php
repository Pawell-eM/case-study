<?php

namespace App\Machine;

interface PurchasedItemInterface
{
    public function getType(): string;

    public function getItemQuantity(): int;

    public function getTotalAmount(): float;

    public function getChange(): array;
}