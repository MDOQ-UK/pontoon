<?php
namespace Mdoq\Pontoon\Model;

use Mdoq\Pontoon\Model\Deck\Card;

class Pontoon
{
    protected Deck $deck;

    protected $hand = [];

    protected $scores = [];

    public function __construct(Deck $deck)
    {
        $this->deck = $deck;
    }

    public function twist()
    {
        if($this->isBust()){
            throw new \Exception('Already bust');
        }
        $this->addCardToHand(
            $this->deck->draw()
        );
    }

    public function addCardToHand(Card $card)
    {
        $this->hand[] = $card;
        $this->scores = [];

        foreach($this->hand as $c){
            $cardScores = $this->getCardScores($c);

            if(empty($this->scores)){
                $this->scores = $cardScores;
            }else{
                if(count($cardScores) > 1){

                    $scores = [];
                    foreach($cardScores as $cardScore){
                        foreach($this->scores as $s){
                            $scores[] = ($s + $cardScore);
                        }
                    }
                    $this->scores = $scores;
                }else{
                    foreach($this->scores as &$s){
                        $s += $cardScores[0];
                    }
                }
            }
        }
    }

    public function isBust()
    {
        return $this->getScore() > 21;
    }

    /**
     * Return the best score
     */
    public function getScore()
    {
        if(count($this->scores) > 0){
            return $this->scores[0];
        }
        return 0;
    }

    /**
     * Return all possible scores
     */
    public function getScores()
    {
        return $this->scores;
    }

    public function getCardScores(Card $card)
    {
        switch($card->getValue()){
            case Deck::VALUE_2:
                return [2];
            case Deck::VALUE_3:
                return [3];
            case Deck::VALUE_4:
                return [4];
            case Deck::VALUE_5:
                return [5];
            case Deck::VALUE_6:
                return [6];
            case Deck::VALUE_7:
                return [7];
            case Deck::VALUE_8:
                return [8];
            case Deck::VALUE_9:
                return [9];
            case Deck::VALUE_ACE:
                return [1, 11];
            case Deck::VALUE_10:
            case Deck::VALUE_JACK:
            case Deck::VALUE_QUEEN:
            case Deck::VALUE_KING:
                return [10];
        }
    }

    public function getHand()
    {
        return $this->hand;
    }
}