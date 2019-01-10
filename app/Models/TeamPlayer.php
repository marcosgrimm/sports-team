<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 10/01/19
 * Time: 16:52
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TeamPlayer extends Model
{
    protected $table = "teams_players";

    protected $fillable = ['team_id', 'player_id', 'start', 'end'];

    public function team(){
        return $this->hasOne(Team::class,'id', 'team_id');

    }
    public function player(){
        return $this->hasOne(Player::class,'id', 'player_id');

    }
}