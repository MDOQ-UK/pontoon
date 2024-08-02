<?php

use Mdoq\Pontoon\Model\Deck;
use Mdoq\Pontoon\Model\Deck\Card;
use Mdoq\Pontoon\Model\Pontoon;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class PontoonTest extends TestCase
{
    #[DataProvider('getTestBestScoreReturnedData')]
    public function testBestScoreReturned($cards, $expectedScore): void
    {
        $game = new Pontoon(new Deck());
        foreach($cards as $card){
            $game->addCardToHand(new Card(Deck::SUIT_CLUBS, $card));
        }

        $this->assertEquals($expectedScore, $game->getScore());
    }

    public static function getTestBestScoreReturnedData()
    {
        return [
            'ace and jack' => [
                'cards' => [
                    Deck::VALUE_ACE,
                    Deck::VALUE_JACK,
                ],
                'expectedScore' => 21,
            ],
            'ace, ace, 3, 2, 5' => [
                'cards' => [
                    Deck::VALUE_ACE,
                    Deck::VALUE_ACE,
                    Deck::VALUE_3,
                    Deck::VALUE_2,
                    Deck::VALUE_5,
                ],
                'expectedScore' => 12,
            ],
            '5, ace' => [
                'cards' => [
                    Deck::VALUE_5,
                    Deck::VALUE_ACE,
                ],
                'expectedScore' => 16,
            ]
        ];
    }
}