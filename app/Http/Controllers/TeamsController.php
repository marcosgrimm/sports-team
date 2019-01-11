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
    public function players(Team $team)
    {
        try {

            $teamPlayers = $team->teamPlayers()->with('player')->get();
        } catch (\Exception $e) {
            return response()->json([], 400);

        }
        return response()->json(["teamPlayers" => $teamPlayers], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $teams = Team::orderBy('name')->get();
        } catch (\Exception $e) {
            return response()->json([], 400);
        }
        return response()->json(["teams" => $teams], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $team = Team::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json(["team" => $team], 200);
    }

    /**
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        try {
            $name = $request->get('name');

            $team->name = $name;
            $team->save();
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json(['team' => $team], 200);
    }

    /**
     * @param CreateTeamRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTeamRequest $request)
    {
        try {
            $name = $request->get('name');
            $team = Team::create(['name' => $name]);
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

        return response()->json(['team' => $team], 200);
    }

    public function destroy($id)
    {
        try {
            \DB::transaction(function () use ($id) {
                TeamPlayer::where('team_id', $id)->delete();
                Team::destroy($id);
            });
        } catch (\Exception $e) {
            return response()->json([], 400);
        }
        return response()->json([], 200);

    }
}
