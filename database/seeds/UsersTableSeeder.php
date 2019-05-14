<?php

use App\Entities\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        factory(User::class)->create([
            'name' => 'Root',
            'email' => 'root@example.com',
            'password' => bcrypt('secret'),
        ]);

        factory(User::class)->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
       ]);

       factory(User::class, 20)->create();
    }
}
