<?php

namespace App\Machine;

use App\Machine\Entity\Candy;
use App\Machine\Exception\MachineLogicException;

class Machine implements MachineInterface
{
    public function __construct(
        private array $availableCandies
    ) {}

    /**
     * @throws MachineLogicException
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface
    {
        $this->validatePurchaseTransaction($purchaseTransaction);
        $candy = $this->getCandy($purchaseTransaction->getType());

        return new PurchasedItem(
            $candy,
            $purchaseTransaction->getItemQuantity(),
            $purchaseTransaction->getPaidAmount(),
        );
    }

    /**
     * @return Candy[]
     */
    public function getAvailableCandies(): array
    {
        return $this->availableCandies;
    }

    private function getCandy(string $type): Candy
    {
        /** @var Candy $candy */
        foreach ($this->availableCandies as $candy) {
            if ($candy->getType() === $type) {
                return $candy;
            }
        }

        throw new MachineLogicException('selected candy is not available');
    }

    private function validatePurchaseTransaction(PurchaseTransactionInterface $purchaseTransaction): void
    {
        $quantity = $purchaseTransaction->getItemQuantity();
        if ($quantity < 1) {
            throw new MachineLogicException('you cannot buy less than 1 item');
        }

        $type = $purchaseTransaction->getType();
        $candy = $this->getCandy($type);

        $givenCash = $purchaseTransaction->getPaidAmount();
        $totalPrice = $quantity * $candy->getPrice();

        if ($totalPrice < 0.01) {
            throw new MachineLogicException('machine configuration error, please call service');
        }
        if ($totalPrice > $givenCash) {
            throw new MachineLogicException(
                sprintf(
                    'less money given (%s) than total cost of selected amount (%s)',
                    number_format($givenCash, 2),
                    number_format($totalPrice, 2)
                )
            );
        }
    }
}