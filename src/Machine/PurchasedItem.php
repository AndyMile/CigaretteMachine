<?php

namespace App\Machine;

/**
 * Class PurchasedItem
 * @package App\Machine
 */
class PurchasedItem implements PurchasedItemInterface {

    /**
    * @var PurchaseTransactionInterface
    */
    private $purchaseTrasaction;

    /**
    * @var array
    */
    private $preparedMoneyForChange = [];

   /**
    * @var float
    */
    private $change;

    /**
     * @param PurchaseTransactionInterface $purchaseTrasaction
     * @param array $moneyForChange
     */
    public function __construct(
        PurchaseTransactionInterface $purchaseTrasaction, 
        array $moneyForChange
    ) 
    {
        $this->purchaseTrasaction = $purchaseTrasaction;
        $this->moneyForChange = $moneyForChange;
        $this->change = round($this->purchaseTrasaction->getPaidAmount() - $this->getTotalAmount(), 2);
        $this->prepareMoneyForChange($moneyForChange);
    }

     /**
     * @return integer
     */
    public function getItemQuantity(): int
     {
        return $this->purchaseTrasaction->getItemQuantity();
    }

    /**
     * get total amount for all packs
     * 
     * @return float
     */
    public function getTotalAmount(): float 
    {
        return $this->purchaseTrasaction->getItemQuantity() * $this->purchaseTrasaction->itemPrice;
    }

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @return array
     */
    public function getChange(): array 
    {
        $result = [];

        foreach ($this->preparedMoneyForChange as $value) {    
            if ($this->change < $value) {
                continue;
            }

            $count = floor((string) ($this->change / $value));
            $this->change -= ($count * $value);
            $this->change = round($this->change, 2);
            $result[] = [$value, $count];   
        }

        return $result;
    }

    /**
     * prepares the change excluding money higher than the change
     * 
     * @return void
     */
    private function prepareMoneyForChange(array $moneyForChange): void
    {
        foreach($moneyForChange as $value) {
            if ($this->change >= $value) {
                array_push($this->preparedMoneyForChange, $value);
            }
        }

        rsort($this->preparedMoneyForChange, SORT_NUMERIC);
    }
}