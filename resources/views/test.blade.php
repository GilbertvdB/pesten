<?php

//deck
class Deck
{
    private $cards;

    public function __construct()
    {
        $this->cards = array();

        $suits = array('♥', '♦', '♣', '♠');
        $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A');

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                // $card = array(
                //     'suit' => $suit,
                //     'value' => $value
                // );
                $card = $suit . $value;

                array_push($this->cards, $card);
            }
        }
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }

    public function setPlayers() {
        $players = ['Abby', 'John', 'Stan', 'Monica'];
        return $players;
    }

    public function dealPlayerCards() {
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
            echo $player . ': ' . implode(', ', $hand) . '<br>';
        }
    }

    public function canMatchCard($card1, $card2)
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
        // print_r($deck);
        $deck->shuffle();
        
        // print_r($deck);
        $playHands = $deck->dealPlayerCards();
        $deck->displayPlayerHands($playHands);
        echo '<br>';

        $players = array_keys($playHands);
        $restDeck = $deck->getRemainingCards();
        $topCard = array_shift($restDeck);
        echo 'Top card: ' . $topCard . '<br>';

        while (true) {
            $gameOver = true; // Flag to track if the game is over

            foreach ($players as $player) {
                

                $canMatch = false;
                $matchingCards = [];

                foreach ($playHands[$player] as $key => $card) {
                    if ($this->canMatchCard($card, $topCard)) {
                        $canMatch = true;
                        array_push($matchingCards, $key);
                    }
                }

                if ($canMatch) {
                    $gameOver = false; // At least one player can still play
                    $randomKey = array_rand($matchingCards);
                    $key = $matchingCards[$randomKey];
                    $matchedCard = $playHands[$player][$key];
                    unset($playHands[$player][$key]);
                    $topCard = $matchedCard;
                    echo $player . ' dropped a card: ' . $matchedCard . '<br>';
                        
                        if (empty($playHands[$player])) {
                            echo $player . ' won the game!<br>';
                            return;
                        }
                } else {
                    if (count($restDeck) === 0) {
                        echo $player . ' cannot draw a card and skips a turn.<br>';
                        continue;
                    }

                    $gameOver = false; // At least one player can still play
                    $randomIndex = array_rand($restDeck);
                    $newCard = $restDeck[$randomIndex];
                    unset($restDeck[$randomIndex]);
                    array_push($playHands[$player], $newCard);
                    echo $player . ' drew a card: ' . $newCard . '<br>';
                }
            }

            if ($gameOver) {
                echo 'The game ended in a draw.<br>';
                return;
            }
        }
    }
}

$game = new Deck();
$game->startGame();


?>
