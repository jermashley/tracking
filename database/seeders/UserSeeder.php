<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jashleyUser = User::create([
            'uuid' => Uuid::uuid4(),
            'first_name' => 'Jeremiah',
            'last_name' => 'Ashley',
            'email' => 'jashley@prologuetechnology.com',
            'password' => bcrypt(Str::random(32)),
            'azure_id' => '4ac75404-9def-41a8-84bb-5e2c37c205bc',
        ]);

        $jashleyUser->syncRoles(['Super Admin']);

        User::factory()
            ->count(10)
            ->create();
    }
}
