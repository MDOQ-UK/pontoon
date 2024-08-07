<?php
namespace Mdoq\Pontoon\Command;

use Mdoq\Pontoon\Model\Deck;
use Mdoq\Pontoon\Model\Pontoon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'play')]
class Play extends Command
{
    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Play Pontoon')
            // the command help shown when running the command with the "--help" option
            ->setHelp('no arguments needed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Game started!');

        // Create a single deck to be used in both the player and the dealer games
        $deck = new Deck();

        // Create a new game for the player
        $playerGame = new Pontoon($deck);

        // You start with 2 cards, not one as in the original code
        $playerGame->twist();
        $playerGame->twist();

        $question = new ChoiceQuestion(
            'Stick or Twist?',
            ['stick', 'twist'],
        );
        $question->setErrorMessage('action %s is invalid.');
        $helper = $this->getHelper('question');

        while(!$playerGame->isBust()){
            $this->displayHand($output, $playerGame);
            $this->displayScore($output, $playerGame);
            $action = $helper->ask($input, $output, $question);

            switch($action){
                case 'stick':
                    break 2;
                case 'twist':
                    $playerGame->twist();
                    break;
            }
            
        }
        $this->displayScore($output, $playerGame);

        if($playerGame->isBust()){
            $output->writeln('Bust, you lose!');
            return Command::SUCCESS;
        }

        $dealerGame = new Pontoon($deck);
        while(!$dealerGame->isBust() && $dealerGame->getScore() < 17){
            $dealerGame->twist();
        }

        if($dealerGame->isBust()){
            $output->writeln('Dealer went bust, you win!');
            return Command::SUCCESS;
        }

        if($dealerGame->getScore() > $playerGame->getScore()){
            $output->writeln('Dealer beat your score, with: '.$dealerGame->getScore().', you lose!');
            return Command::SUCCESS;
        }elseif($dealerGame->getScore() == $playerGame->getScore()){
            $output->writeln('Dealer matched your score, you lose! (the house always wins)');
            return Command::SUCCESS;
        }

        $output->writeln('Dealer scored: '.$dealerGame->getScore().', you WIN!');
        return Command::SUCCESS;
    }

    protected function displayHand(OutputInterface $output, Pontoon $game)
    {
        $output->writeln('Your hand:');
        foreach ($game->getHand() as $card) {
            $output->writeln(' - ' . (string)$card);
        }
    }

    protected function displayScore(OutputInterface $output, Pontoon $game)
    {
        $output->writeln('Your score: '.$game->getScore());
    }
}