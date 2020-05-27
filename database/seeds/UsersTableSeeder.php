<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        factory(User::class, 100)->create();

        $first_user = User::find(1);
        $first_user->username = 'll';
        $first_user->save();
    }
}
