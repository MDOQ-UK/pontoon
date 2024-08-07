<?php
namespace Mdoq\Pontoon\Model;

use Mdoq\Pontoon\Model\Deck\Card;

class Deck
{
    public const SUIT_DIAMONDS = 'diamonds';
    public const SUIT_HEARTS = 'hearts';
    public const SUIT_CLUBS = 'clubs';
    public const SUIT_SPADES = 'spades';
    public const SUITS = [
        self::SUIT_DIAMONDS,
        self::SUIT_HEARTS,
        self::SUIT_CLUBS,
        self::SUIT_SPADES,
    ];

    public const VALUE_1 = '1';
    public const VALUE_2 = '2';
    public const VALUE_3 = '3';
    public const VALUE_4 = '4';
    public const VALUE_5 = '5';
    public const VALUE_6 = '6';
    public const VALUE_7 = '7';
    public const VALUE_8 = '8';
    public const VALUE_9 = '9';
    public const VALUE_10 = '10';
    public const VALUE_ACE = 'ace';
    public const VALUE_KING = 'king';
    public const VALUE_QUEEN = 'queen';
    public const VALUE_JACK = 'jack';
    public const VALUES = [
        self::VALUE_2,
        self::VALUE_3,
        self::VALUE_4,
        self::VALUE_5,
        self::VALUE_6,
        self::VALUE_7,
        self::VALUE_8,
        self::VALUE_9,
        self::VALUE_10,
        self::VALUE_ACE,
        self::VALUE_KING,
        self::VALUE_QUEEN,
        self::VALUE_JACK,
    ];

    protected $cards = [];

    public function __construct()
    {
        foreach(self::SUITS as $suit){
            foreach(self::VALUES as $value){
                $this->cards[] = new Card($suit, $value);
            }
        }
        shuffle($this->cards);
    }

    public function draw()
    {
        return array_shift($this->cards);
    }
}