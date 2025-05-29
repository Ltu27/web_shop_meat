<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        User::updateOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'email' => 'admin@gmail.com',
            'name' => 'THE FACE SHOP admin',
            'password' => '12345678',
            'email_verified_at' => Carbon::now(),
        ]);
        // User::factory()->count(30)->create();
    }
}
