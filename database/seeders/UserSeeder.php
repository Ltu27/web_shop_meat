<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::updateOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'email' => 'admin@gmail.com',
            'phone' => '1234567890',
            'name' => 'Bemet admin',
            'password' => '12345678',
            'email_verified_at' => Carbon::now(),
        ]);
        // User::factory()->count(30)->create();
    }
}
