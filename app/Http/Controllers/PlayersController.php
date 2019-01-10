<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;

class PlayersController extends Controller
{
    public function index()
    {
        $players = Player::all();

        return response()->json(["players"=>$players], 200);
    }

    public function show($id)
    {
        $player = Player::find($id);

        return response()->json(["player"=>$player], 200);
    }

    public function update( UpdatePlayerRequest $request, Player $player)
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');

        $player->first_name = $firstName;
        $player->last_name = $lastName;
        $player->save();

        return response()->json(['player'=>$player],200);
    }

    public function store(CreatePlayerRequest $request)
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');

        $player = new Player();
        $player->first_name = $firstName;
        $player->last_name = $lastName;

        $player->save();

        return response()->json(['player'=>$player],200);
    }

    public function destroy($id)
    {
        Player::destroy($id);
    }
}
