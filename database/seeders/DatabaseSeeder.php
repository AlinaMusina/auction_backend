<?php

namespace Database\Seeders;

use App\Models\Items;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'user1',
            'email' => 'user1@fake.com',
            'password' => Hash::make('user1'),
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@fake.com',
            'password' => Hash::make('user2'),
        ]);

        Items::create([
            'name' => 'First auction',
            'description' => 'Description 1',
            'price' => 123.45,
            'end_time' => '2021-10-09',
            'is_closed' => 0,
        ]);

        Items::create([
            'name' => 'Second auction',
            'description' => 'Description 2',
            'price' => 234.56,
            'end_time' => '2021-11-09',
            'is_closed' => 0,
        ]);
    }
}
