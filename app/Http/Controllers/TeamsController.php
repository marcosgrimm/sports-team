<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;

class TeamsController extends Controller
{
    public function players(Team $team){
        $teamPlayers = $team->teamPlayers()->with('player')->get();
        return response()->json(["teamPlayers" => $teamPlayers], 200);
    }

    public function index()
    {
        $teams = Team::orderBy('name')->get();

        return response()->json(["teams"=>$teams], 200);
    }

    public function show($id)
    {
        $team = Team::find($id);

        return response()->json(["team"=>$team], 200);
    }

    public function update( UpdateTeamRequest $request, Team $team)
    {
        $name = $request->get('name');

        $team->name = $name;
        $team->save();

        return response()->json(['team'=>$team],200);
    }

    public function store(CreateTeamRequest $request)
    {
        $name = $request->get('name');
        $team = Team::create(['name' => $name]);

        return response()->json(['team'=>$team],200);
    }

    public function destroy($id)
    {
        Team::destroy($id);
    }
}
