<?php

use Illuminate\Database\Seeder;

class TeamSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Team::class, 50)->create();
    }
}
