<?php

namespace App;

class Deck
{
    private $cards;
    private $results = [];

    public function __construct()
    {
        $this->cards = array();

        $suits = array('♥', '♦', '♣', '♠');
        $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A');

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $card = $suit . $value;
                array_push($this->cards, $card);
            }
        }
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }

    private function setPlayers() 
    {
        $players = ['Abby', 'John', 'Stan', 'Monica'];
        return $players;
    }

    private function dealPlayerCards() 
    {
        $players = $this->setPlayers();
        $playerHands = array_fill_keys($players, []);

        for ($i = 0; $i < 7; $i++) {
            foreach ($players as $player) {
                $randomIndex = array_rand($this->cards);
                $card = array_splice($this->cards, $randomIndex, 1)[0];
                array_push($playerHands[$player], $card);
            }
        }

        return $playerHands;
    }
    
    private function getRemainingCards()
    {
        return $this->cards;
    }

    private function displayTime()
    {
        return '[' . date('H:i:s') . '] - ';
    }

    private function displayStartGame()
    {
        $this->results[] = $this->displayTime() . 'Starting game with ' . implode(', ', $this->setPlayers());
    }

    private function displayPlayerHands($playerHands)
    {
        foreach ($playerHands as $player => $hand) {
            $this->results[] = $this->displayTime() . $player . ' has been dealt: ' . implode(', ', $hand);
        }
    }

    private function displayTopCard($restDeck)
    {
        $setTopCard = array_shift($restDeck);
        $this->results[] = $this->displayTime() . 'Top card is: ' . $setTopCard;
        return $setTopCard;
    }

    private function canMatchCard($card1, $card2)
    {
        $suit1 = substr($card1, 0, -1);
        $suit2 = substr($card2, 0, -1);
        $value1 = substr($card1, -1);
        $value2 = substr($card2, -1);

        return ($suit1 === $suit2) || ($value1 === $value2);
    }

    private function getMatchedCard(&$playersHand, $player, $matchingCards)
    {
        $randomKey = array_rand($matchingCards);
        $key = $matchingCards[$randomKey];
        $matchedCard = $playersHand[$player][$key];
        unset($playersHand[$player][$key]);
        return $matchedCard;
    }

    private function initGame()
    {
        $deck = new Deck();
        $deck->shuffle();
        $playersHand = $deck->dealPlayerCards();
        $this->displayStartGame();
        $this->displayPlayerHands($playersHand);
        $players = array_keys($playersHand);
        $restDeck = $deck->getRemainingCards();
        $topCard = $this->displayTopCard($restDeck);

        return [$playersHand, $players, $restDeck, $topCard];
    }

    public function startGame() 
    {        
        list($playersHand, $players, $restDeck, $topCard) = $this->initGame();

        $skipCounter = 0;

        while (true) {
            $gameOver = false;

            foreach ($players as $player) {
                $canMatch = false;
                $matchingCards = [];

                // Creates an array with all the matching cards if possible.
                foreach ($playersHand[$player] as $key => $card) {
                    if ($this->canMatchCard($card, $topCard)) {
                        $canMatch = true;
                        array_push($matchingCards, $key);
                    }
                }

                if ($canMatch) {
                    $skipCounter = 0; // Reset the skip counter

                    $matchedCard = $this->getMatchedCard($playersHand, $player, $matchingCards);
                    $topCard = $matchedCard;
                    $this->results[] = $this->displayTime() . $player . ' plays: ' . $matchedCard;
                        
                    if (empty($playersHand[$player])) {
                        $this->results[] = $this->displayTime() . $player . ' won the game!';
                        $gameOver = true;
                        return;
                    }
                } else {
                    if (count($restDeck) === 0) {
                        $skipCounter++;
                        $this->results[] = $this->displayTime() . $player . ' cannot draw, skips turn';

                        if ($skipCounter === count($players)) {
                            $this->results[] = $this->displayTime() . 'The game ended in a draw.';
                            $gameOver = true;
                            return;
                            }

                        continue;
                    }
                    
                    $newCard = array_shift($restDeck);
                    array_push($playersHand[$player], $newCard);
                    $this->results[] = $this->displayTime() . $player . ' draws: ' . $newCard;
                }
            }
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}
