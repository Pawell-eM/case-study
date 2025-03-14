<?php

namespace App\Command;

use App\Machine\MachineInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

final class PurchaseCandyCommand extends Command
{
    private MachineInterface $machine;

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

            $type = (string)$helper->ask($input, $output, $this->createTypeChoice([/** @todo replace with proper choices */ 'foo']));
            $itemCount = (int)$helper->ask($input, $output, $this->createQuestion('Please input packs of candy you want to buy (Default: 1)> ', 1));
            $paymentAmount = (float)$helper->ask($input, $output, $this->createQuestion('Please input necessary amount to pay> '));

            // @todo implement business logic
            // $result = $this->machine->execute(...);

            // @todo fill output as specified in README.md
            // $output->writeln('You bought <info>...</info> packs of <info>...</info> for <info>...</info>, each for <info>...</info>. ');
            // $output->writeln('Your change is:');
            // $table = new Table($output);
            // ...
        }
    }

    private function createTypeChoice(array $choices): Question
    {
        $question = new ChoiceQuestion('Welcome, dear customer! Please select your favorite candy', $choices);
        $question->setErrorMessage('Candy selection %s is invalid.');

        return $question;
    }

    #[Pure] private function createQuestion(string $description, $default = null): Question
    {
        return new Question($description, $default);
    }
}