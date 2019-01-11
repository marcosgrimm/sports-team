<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 10/01/19
 * Time: 01:02
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function players()
    {
        return $this->hasManyThrough(Player::class, TeamPlayer::class,'team_id', 'id',null, 'player_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamPlayers()
    {
        return $this->hasMany( TeamPlayer::class,'team_id', 'id');
    }
}