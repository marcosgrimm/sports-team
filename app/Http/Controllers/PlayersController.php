<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use App\Models\TeamPlayer;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    /**
     * @param Player $player
     * @return \Illuminate\Http\JsonResponse
     */
    public function teams(Player $player)
    {
        try {
            $playerTeams = $player->playerTeams()->with('team')->get();
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json(["playerTeams" => $playerTeams], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $players = Player::all();
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json(["players" => $players], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $player = Player::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json(["player" => $player], 200);
    }

    /**
     * @param Request $request
     * @param Player $player
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Player $player)
    {
        try {
            $player = \DB::transaction(function () use ($request, $player) {
                $playerRequest = $request->get('player');
                $team = $request->get('team');

                $firstName = $playerRequest['first_name'];
                $lastName = $playerRequest['last_name'];

                $teamId = $team['id'];
                $start = $team['start'];
                $end = $team['end'];


                $player->first_name = $firstName;
                $player->last_name = $lastName;
                $player->save();

                if ($teamId && $start && $end) {
                    $teamPlayer = new TeamPlayer();
                    $teamPlayer->team_id = $teamId;
                    $teamPlayer->player_id = $player->id;
                    $teamPlayer->start = $start;
                    $teamPlayer->end = $end;
                    $teamPlayer->save();
                }

                return $player;

            });
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json(['player' => $player], 200);
    }

    /**
     * @param CreatePlayerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePlayerRequest $request)
    {
        try {
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

                if ($teamId && $start && $end) {
                    $teamPlayer = new TeamPlayer();
                    $teamPlayer->team_id = $teamId;
                    $teamPlayer->player_id = $player->id;
                    $teamPlayer->start = $start;
                    $teamPlayer->end = $end;
                    $teamPlayer->save();
                }

                return $player;
            });

            return response()->json(['player' => $player], 200);
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            \DB::transaction(function () use ($id) {
                TeamPlayer::where('player_id', $id)->delete();
                Player::destroy($id);
            });
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json([], 200);

    }
}
