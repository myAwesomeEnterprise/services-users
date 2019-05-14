<?php

use App\Entities\User;
use Illuminate\Database\Seeder;

class BouncerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('root')->everything();

        $root = User::where('email', 'root@example.com')->first();
        Bouncer::assign('root')->to($root);
    }
}
