<?php

use Mdoq\Pontoon\Model\Deck;
use PHPUnit\Framework\TestCase;

final class DeckTest extends TestCase
{
    public function testExceptionThrownIfNoCardsLeft(): void
    {
        $deck = new Deck();
        for($i=0; $i<52; $i++){
            $deck->draw();
        }
        $this->expectException(\Exception::class);
        $deck->draw();
    }
}