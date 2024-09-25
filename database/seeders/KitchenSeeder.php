<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KitchenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // Buat 10 user baru dengan access 'yes'
        User::factory(10)->create([
            'access' => 'yes',
            'role' => 'kitchen',
        ]);
    }
}
