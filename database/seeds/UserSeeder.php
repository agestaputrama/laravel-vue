<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('users')->insert([
            [
            'id' => Str::uuid(),
            'role_id' => get_admin_id(),
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(), 
        ], [
            'id' => Str::uuid(),
            'role_id' => get_user_id(),
            'name' => 'ages',
            'email' => 'ages@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(), 
        ]
        ]);
    }
}
