<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use App\Models\TeamPlayer;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function teams(Player $player)
    {
        $playerTeams = $player->playerTeams()->with('team')->get();

        return response()->json(["playerTeams" => $playerTeams], 200);
    }

    public function index()
    {
        $players = Player::all();

        return response()->json(["players" => $players], 200);
    }

    public function show($id)
    {
        $player = Player::find($id);

        return response()->json(["player" => $player], 200);
    }

    public function update(Request $request, Player $player)
    {
        $player = \DB::transaction(function () use ($request, $player) {
            $playerRequest = $request->get('player');
            $firstName = $playerRequest['first_name'];
            $lastName = $playerRequest['last_name'];

            $team = $request->get('team');
            $teamId = $team['id'];
            $start = $team['start'];
            $end = $team['end'];


            $player->first_name = $firstName;
            $player->last_name = $lastName;
            $player->save();

            $teamPlayer = new TeamPlayer();
            $teamPlayer->team_id = $teamId;
            $teamPlayer->player_id = $player->id;
            $teamPlayer->start = $start;
            $teamPlayer->end = $end;
            $teamPlayer->save();

            return $player;

        });
        return response()->json(['player' => $player], 200);
    }

    public function store(CreatePlayerRequest $request)
    {

        $player = \DB::transaction(function () use ($request) {
            $firstName = $request->get('first_name');
            $lastName = $request->get('last_name');
            $team = $request->get('team');
            $teamId = $team['id'];
            $start = $team['start'];
            $end = $team['end'];

            $player = new Player();
            $player->first_name = $firstName;
            $player->last_name = $lastName;
            $player->save();

            $teamPlayer = new TeamPlayer();
            $teamPlayer->team_id = $teamId;
            $teamPlayer->player_id = $player->id;
            $teamPlayer->start = $start;
            $teamPlayer->end = $end;
            $teamPlayer->save();

            return $player;
        });

        return response()->json(['player' => $player], 200);
    }

    public function destroy($id)
    {
        Player::destroy($id);

        return response()->json([], 200);

    }
}
