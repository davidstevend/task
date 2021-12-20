<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'David duran',
            'email' => 'davidstevend@hotmail.com',
            'password' => bcrypt('12345678')
        ]);
        
        User::factory(31)->create();
        
    }
}