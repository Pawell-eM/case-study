<?php

namespace App\Machine;

use App\Machine\Entity\Candy;

class PurchasedItem implements PurchasedItemInterface
{
    private array $coins = [0.5, 0.2, 0.1, 0.05, 0.02, 0.01];
    public function __construct(
        private Candy $candy,
        private int $itemQuantity,
        private float $paidAmount,
    ) {}

    public function getType(): string
    {
        return $this->candy->getType();
    }

    public function getItemQuantity(): int
    {
        return $this->itemQuantity;
    }

    public function getTotalAmount(): float
    {
        return $this->candy->getPrice() * $this->itemQuantity;
    }

    public function getChange(): array
    {
        $change = [];
        $changeAmount = $this->paidAmount - $this->getTotalAmount();
        if ($changeAmount < 0.01) {
            return $change;
        }

        $coinIdx = 0;
        do {
            $coin = $this->coins[$coinIdx] ?? 0.01; // in case of some unexpected error
            $count = floor($changeAmount / $coin);
            if ($count > 0) {
                $change[] = [$coin, $count];
                $changeAmount -= $coin * $count;
            }
            $coinIdx++;
        }
        while ($changeAmount >= 0.01);

        return $change;
    }
}