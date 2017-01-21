<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'       => env('USERNAME', 'admin'),
            'email'      => env('EMAIL', 'admin@example.com'),
            'password'   => bcrypt(env('PASSWORD', 'admin')),
            'api_token'  => str_random(60),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
