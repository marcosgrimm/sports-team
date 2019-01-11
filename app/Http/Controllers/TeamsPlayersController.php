<?php

namespace App\Http\Controllers;

use App\Models\TeamPlayer;

class TeamsPlayersController extends Controller
{

    /**
     * @param $teamId
     * @param $playerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($teamId, $playerId)
    {
        try {
            TeamPlayer::where('team_id', $teamId)
                ->where('player_id', $playerId)
                ->delete();
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json([], 200);

    }
}
