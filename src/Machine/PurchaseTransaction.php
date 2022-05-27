<?php

namespace App\Machine;

/**
 * Class PurchaseTransaction
 * @package App\Machine
 */
class PurchaseTransaction implements PurchaseTransactionInterface
{
    /**
     * @var int
     */
    private $itemQuantity;

     /**
     * @var float
     */
    public $itemPrice;

    /**
     * @var float
     */
    private $paidAmount;

    /**
     * @param int   $itemQuantity
     * @param float $paidAmount
     */
    public function __construct($itemQuantity, $paidAmount, $itemPrice)
    {
        $this->itemQuantity = $itemQuantity;
        $this->paidAmount = $paidAmount;
        $this->itemPrice = $itemPrice;
        $this->checkPaidAmount();
    }

    /**
     * @return int
     */
    public function getItemQuantity(): int
    {
        return $this->itemQuantity;
    }

    /**
    * @return float
    */
    public function getPaidAmount(): float
    {
        return $this->paidAmount;
    }

    /**
    * checks if the correct amount provided to buy packs
    * 
    * @return float
    */
    private function checkPaidAmount(): bool 
    {
        if ($this->paidAmount - ($this->itemQuantity * $this->itemPrice) < 0) {
            throw new \Exception(
                sprintf(
                    'Not enough money to buy. Paid: %s. Need to pay: %s.',
                    $this->paidAmount,
                    $this->itemQuantity * $this->itemPrice
                )
            );
        }

        return true;
    }
}