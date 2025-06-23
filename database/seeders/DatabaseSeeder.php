<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $arr = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'test_account@yopmail.com',
                'role_id' => 1,
                'password' => bcrypt(123456)
            ],
            [
                'id' => 2,
                'name' => 'Admin2',
                'email' => 'test_account2@yopmail.com',
                'role_id' => 1,
                'password' => bcrypt(123456)
            ]
        ];

        foreach ($arr as $value) {
            User::updateOrCreate(
                ['id' => $value['id']],
                $value
            );
        }
    }
}
