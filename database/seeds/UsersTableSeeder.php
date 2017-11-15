<?php

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
        DB::table('users')->insert([
            'id' => 'ab01',
            'name' => 'test',
            'email' => 'test@test.test',
            'type' => 'teacher'
        ]);
    }
}
