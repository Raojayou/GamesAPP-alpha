<?php
namespace App\Controllers;

use App\Models\Game;

class ApiController
{
    public function getGames($id = null)
    {
        if (is_null($id)) {
            $games = Game::all();

            header('Content-Type: application/json');
            return json_encode($games);
        } else {
            $game = Game::find($id);

            header('Content-Type: application/json');
            return json_encode($game);
        }
    }
}