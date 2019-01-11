<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\TeamPlayer;

class TeamsController extends Controller
{
    /**
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function players(Team $team){
        $teamPlayers = $team->teamPlayers()->with('player')->get();
        return response()->json(["teamPlayers" => $teamPlayers], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $teams = Team::orderBy('name')->get();

        return response()->json(["teams"=>$teams], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $team = Team::find($id);

        return response()->json(["team"=>$team], 200);
    }

    /**
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $name = $request->get('name');

        $team->name = $name;
        $team->save();

        return response()->json(['team'=>$team],200);
    }

    /**
     * @param CreateTeamRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTeamRequest $request)
    {
        $name = $request->get('name');
        $team = Team::create(['name' => $name]);

        return response()->json(['team'=>$team],200);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        TeamPlayer::where('team_id',$id)->delete();
        Team::destroy($id);
    }
}
