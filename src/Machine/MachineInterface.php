<?php

namespace App\Machine;

interface MachineInterface
{
    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface;
}