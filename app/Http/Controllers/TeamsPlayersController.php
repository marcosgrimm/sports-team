<?php

namespace App\Http\Controllers;

use App\Models\TeamPlayer;

class TeamsPlayersController extends Controller
{

    public function destroy($teamId, $playerId)
    {
        TeamPlayer::where('team_id', $teamId)
            ->where('player_id', $playerId)
            ->delete();

        return response()->json([], 200);

    }
}
