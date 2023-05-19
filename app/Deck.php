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

    public function setPlayers() 
    {
        $players = ['Abby', 'John', 'Stan', 'Monica'];
        return $players;
    }

    public function dealPlayerCards()
    {
        $deck = $this->cards;
        
        $players = $this->setPlayers();
        $playerHands = array_fill_keys($players, []);

        for ($i = 0; $i < 7; $i++) {
            foreach ($players as $player) {
                $randomIndex = array_rand($deck);
                $card = array_splice($deck, $randomIndex, 1)[0];
                array_push($playerHands[$player], $card);
            }
        }

        return $playerHands;
    }
    
    public function getRemainingCards()
    {
        return $this->cards;
    }

    public function displayPlayerHands($playerHands)
    {
        foreach ($playerHands as $player => $hand) {
            $this->results[] = '[' . date('H:i:s') . '] - ' . $player . ' has been dealt: ' . implode(', ', $hand);
        }
    }

    private function canMatchCard($card1, $card2)
    {
        $suit1 = substr($card1, 0, -1);
        $suit2 = substr($card2, 0, -1);
        $value1 = substr($card1, -1);
        $value2 = substr($card2, -1);

        return ($suit1 === $suit2) || ($value1 === $value2);
    }

    public function startGame() 
{
    $deck = new Deck();
    $deck->shuffle();
    
    $playersHand = $deck->dealPlayerCards();
    $this->results[] = '[' . date('H:i:s') . '] - ' . 'Starting game with ' . implode(', ', $this->setPlayers());
    $this->displayPlayerHands($playersHand);

    $players = array_keys($playersHand);
    $restDeck = $deck->getRemainingCards();
    $topCard = array_shift($restDeck);
    $this->results[] = '[' . date('H:i:s') . '] - ' . 'Top card is: ' . $topCard;
    
    $skipCounter = 0;

    while (true) {
        $gameOver = true; // Flag to track if the game is over when no player can play

        foreach ($players as $player) {
            $canMatch = false;
            $matchingCards = [];

            foreach ($playersHand[$player] as $key => $card) {
                if ($this->canMatchCard($card, $topCard)) {
                    $canMatch = true;
                    array_push($matchingCards, $key);
                }
            }

            if ($canMatch) {
                $gameOver = false; // At least one player can still play
                $skipCounter = 0; // Reset the skip counter
                $randomKey = array_rand($matchingCards);
                $key = $matchingCards[$randomKey];
                $matchedCard = $playersHand[$player][$key];
                unset($playersHand[$player][$key]);
                $topCard = $matchedCard;
                $this->results[] = '[' . date('H:i:s') . ']' . ' - ' . $player . ' plays: ' . $matchedCard;
                    
                if (empty($playersHand[$player])) {
                    $this->results[] = '[' . date('H:i:s') . '] - ' . $player . ' won the game!';
                    return;
                }
            } else {
                if (count($restDeck) === 0) {
                    $this->results[] = '[' . date('H:i:s') . '] - ' . $player . ' cannot draw, skips turn';
                    $skipCounter++;
                    continue;
                }
                
                $gameOver = false; // At least one player can still play
                $skipCounter = 0; // Reset the skip counter
                $randomIndex = array_rand($restDeck);
                $newCard = $restDeck[$randomIndex];
                unset($restDeck[$randomIndex]);
                array_push($playersHand[$player], $newCard);
                $this->results[] = '[' . date('H:i:s') . '] - ' . $player . ' draws: ' . $newCard;
            }
        }

        if ($gameOver || $skipCounter === count($players)) {
            $this->results[] = '[' . date('H:i:s') . '] - ' . 'The game ended in a draw.';
            return;
        }
    }
}

    public function getResults()
    {
        return $this->results;
    }
}
