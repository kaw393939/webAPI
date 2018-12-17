<?php

use App\User;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::All();
        $users->each(function ($user) {
            $profile = factory(\App\Profile::class)->make();
            $user->profile()->save($profile);
        });
    }
}
