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
            ->setHelp('No Arguments Needed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Game started!');
        $game = new Pontoon(new Deck());
        $game->twist();

        $this->displayHand($output, $game);

        $question = new ChoiceQuestion(
            'Stick or Twist?',
            ['stick', 'twist'],
        );
        $question->setErrorMessage('action %s is invalid.');
        $helper = $this->getHelper('question');

        while(!$game->isBust()){
            $action = $helper->ask($input, $output, $question);

            switch($action){
                case 'stick':
                    break 2;
                case 'twist':
                    $game->twist();
                    $this->displayHand($output, $game);
                    break;
            }
        }

        if($game->isBust()){
            $output->writeln('Bust, you lose!');
            return Command::SUCCESS;
        }

        $dealerGame = new Pontoon(new Deck());
        while(!$dealerGame->isBust() && $dealerGame->getScore() < 17){
            $dealerGame->twist();
        }

        if($dealerGame->isBust()){
            $output->writeln('Dealer went bust, you win!');
            return Command::SUCCESS;
        }

        if($dealerGame->getScore() > $game->getScore()){
            $output->writeln('Dealer beat your score, with: '.$dealerGame->getScore().', you lose!');
            return Command::SUCCESS;
        }elseif($dealerGame->getScore() == $game->getScore()){
            $output->writeln('Dealer matched your socre, you lose! (the house always wins)');
            return Command::SUCCESS;
        }

        $output->writeln('Dealer scored: '.$dealerGame->getScore().', you WIN!');
        return Command::SUCCESS;
    }

    protected function displayHand(OutputInterface $output, Pontoon $game)
    {
        $hand = $game->getHand();
        $displayArray = [];

        foreach ($hand as $card) {
            $cardInfo = $card->jsonSerialize();
            array_push($displayArray, $cardInfo);
        }

        $displayHand = implode(", ", $displayArray);

        $output->writeln("Your hand:  [$displayHand]");
    }
}