<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    const AVAILABLE_MONEY_FOR_CHANGE = [
        0.01,
        0.02,
        0.05,
        0.1,
        0.2,
        0.5,
        1,
        5,
        10,
        20,
        50,
        100
    ];

    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface
    {
        return new PurchasedItem($purchaseTransaction, self::AVAILABLE_MONEY_FOR_CHANGE);
    }
}