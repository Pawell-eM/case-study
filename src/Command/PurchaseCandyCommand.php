<?php

namespace App\Command;

use App\Machine\Exception\MachineLogicException;
use App\Machine\Machine;
use App\Machine\PurchaseTransaction;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

final class PurchaseCandyCommand extends Command
{
    private Machine $machine;

    public function __construct(array $availableCandies)
    {
        $this->machine = new Machine($availableCandies);

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName("purchase-candy");

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        while (true) {
            $continue = $helper->ask($input, $output, new ConfirmationQuestion('Welcome, dear customer! Would you like to buy some candy? (y/n)'));

            if (!$continue) {
                return Command::SUCCESS;
            }

            $choices = [];
            foreach ($this->machine->getAvailableCandies() as $k => $candy) {
                $choices[$k] = $candy->getType();
            }

            $type = trim((string)$helper->ask($input, $output, $this->createTypeChoice($choices)));
            $itemCount = (int)$helper->ask($input, $output, $this->createQuestion('Please input packs of candy you want to buy (Default: 1)> ', 1));
            $paymentAmount = (float)$helper->ask($input, $output, $this->createQuestion('Please input amount of cash you want to pay> '));

            try {
                $purchaseTransaction = new PurchaseTransaction($type, $itemCount, $paymentAmount);
                $purchasedItem = $this->machine->execute($purchaseTransaction);
            }
            catch (MachineLogicException $e) {
                $output->writeln('<error>' . $e->getMessage() . '</error>');
                return Command::FAILURE;
            }

            $output->writeln(
                sprintf(
                    'You bought <info>%d</info> packs of <info>%s</info> for <info>%s</info>€, each for <info>%s</info>€. ',
                    $purchasedItem->getItemQuantity(),
                    $purchasedItem->getType(),
                    number_format($purchasedItem->getTotalAmount(), 2),
                    number_format($purchasedItem->getTotalAmount() / $purchasedItem->getItemQuantity(), 2),
                )
            );

            $changeData = $purchasedItem->getChange();
            if (count($changeData) > 0) {
                $output->writeln('Your change is:');

                $table = new Table($output);
                $table
                    ->setHeaders(['Coin', 'Count'])
                    ->setRows($changeData)
                    ->render();
            }

            return Command::SUCCESS;
        }
    }

    private function createTypeChoice(array $choices): Question
    {
        $question = new ChoiceQuestion('Please select your favorite candy', $choices);
        $question->setErrorMessage('Candy selection %s is invalid.');

        return $question;
    }

    #[Pure] private function createQuestion(string $description, $default = null): Question
    {
        return new Question($description, $default);
    }
}