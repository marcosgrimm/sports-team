<?php

use Illuminate\Database\Seeder;

class TeamsPlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\TeamPlayer::class,500)->create();
    }
}
