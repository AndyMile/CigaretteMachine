<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Machine\PurchaseTransaction;
use App\Machine\CigaretteMachine;

/**
 * Class CigaretteMachine
 * @package App\Command
 * 
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

        if ($itemCount < 1) {
            $output->writeln('Enter a number of cigarettes packs, please.');
            exit();
        }

        if ($amount == 0) {
            $output->writeln('Provide the payment, please.');
            exit();
        }

        try {
            $cigaretteMachine = new CigaretteMachine();
            $purchaseTransaction = $cigaretteMachine->execute(new PurchaseTransaction($itemCount, $amount, $cigaretteMachine::ITEM_PRICE));

        } catch (\Exception $e) {
            $output->writeln(sprintf('The error occurred: %s', $e->getMessage()));
            exit();
        }

        $output->writeln(
            sprintf(
                'You bought <info>%s</info> packs of cigarettes for <info>%s</info>, each for <info>%s</info>.',
                $purchaseTransaction->getItemQuantity(),
                $purchaseTransaction->getTotalAmount(),
                $cigaretteMachine::ITEM_PRICE,
            )
        );
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows($purchaseTransaction->getChange());
        $table->render();
    }
}