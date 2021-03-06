<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
            'id' => Str::uuid(),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(), 
        ], [
            'id' => Str::uuid(),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(), 
        ]
        ]);
    }
}
