<?php

namespace App\Machine;

interface PurchaseTransactionInterface
{
    public function getType(): string;

    public function getItemQuantity(): int;

    public function getPaidAmount(): float;
}