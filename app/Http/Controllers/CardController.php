<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deck;

class CardController extends Controller
{
    public function index()
    {
        $game = new Deck();
        $game->startGame();
        $results = $game->getResults();

        return view('welcome', compact('results'));
    }
 
}

?>