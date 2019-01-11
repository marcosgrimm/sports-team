<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 10/01/19
 * Time: 15:33
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Player extends Model
{

    protected $fillable = ['first_name', 'last_name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playerTeams()
    {
        return $this->hasMany(TeamPlayer::class, 'player_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function teams()
    {
        return $this->hasManyThrough(Team::class, TeamPlayer::class, 'player_id', 'id', null, 'team_id');
    }
}