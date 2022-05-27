<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Machine\PurchaseTransaction;
use App\Machine\CigaretteMachine;

final class PurchaseTransactionTest extends TestCase {

    public function testGetItemQuantity() 
    {
        $this->assertEquals((new PurchaseTransaction(1, 10, CigaretteMachine::ITEM_PRICE))->getItemQuantity(), 1);
    }

    public function testGetPaidAmount() 
    {
        $this->assertEquals((new PurchaseTransaction(1, 10, CigaretteMachine::ITEM_PRICE))->getPaidAmount(), 10);
    }
}