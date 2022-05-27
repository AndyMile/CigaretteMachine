<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use  App\Machine\PurchaseTransactionInterface;

final class CigaretteMachineTest extends TestCase {

    /**
     * @dataProvider additionProvider
     */
    public function testCigaretteMachineChange(PurchaseTransactionInterface $purchaseTransaction, array $change) 
    {
        $result = (new CigaretteMachine)->execute($purchaseTransaction)->getChange();
        $this->assertEquals($change, $result);
    }

    public function additionProvider(): array
    {
        return [
            [
                new PurchaseTransaction(1, 10, CigaretteMachine::ITEM_PRICE),
                [
                    [5, 1],
                    [0.01, 1]
                ]
            ],
            [
                new PurchaseTransaction(7, 50, CigaretteMachine::ITEM_PRICE),
                [
                    [10, 1],
                    [5, 1],
                    [0.05, 1],
                    [0.02, 1]
                ]
            ],
            [
                new PurchaseTransaction(12, 100, CigaretteMachine::ITEM_PRICE),
                [
                    [20, 2],
                    [0.1, 1],
                    [0.02, 1]
                ]
            ],
        ];
    }
}
