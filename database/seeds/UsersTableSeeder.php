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
            'id' => 'bkjfskumgjwlirykw',
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => Hash::make('test')
        ]);
    }
}
