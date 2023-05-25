<p align="center">Welcome!</p>

## About Pesten

This is a webapplication that runs and displays results of a game called "pesten".
It is made using Laravel Framework and Php.

## Rules

Here are the rules:

- Shuffle a deck of cards without the jokers.
- Deal each player 7 cards.
- Players take turn after each other Round-robin style.
- The top card of the remaining deck wil be turned over and shown.
- The top card is the starting card an players must try to match the suits of the ranks.
- A player drops 1 card if it can be matched.
- A player draw 1 card from the deck if it cant be matched.
- A player skips turn if there are no cards left in the deck to draw.
- A player wins the game when his hands has no cards left.
- If all players can no longer play a card or draw the game ends in a draw.

## Files
<a href="https://github.com/GilbertvdB/pesten/blob/master/app/Deck.php">The class file can be found here</a>
<a href="https://github.com/GilbertvdB/pesten/blob/code-optimization/app/Deck.php">New class version here!</a>

<a href="https://github.com/GilbertvdB/pesten/blob/master/app/Http/Controllers/CardController.php">The controller can be found here</a>


<a href="https://github.com/GilbertvdB/pesten/blob/master/resources/views/welcome.blade.php">The view can be found here</a>


## Previews

Win!
<br>
![test_opdracht_win](https://github.com/GilbertvdB/pesten/assets/101508384/40b10d61-c78c-4342-b554-0945b824688c)
<br>
<br>

Draw!
<br>
![test_opdracht_draw](https://github.com/GilbertvdB/pesten/assets/101508384/da55dd83-cf5b-4b86-93aa-48562ff4c6e6)
