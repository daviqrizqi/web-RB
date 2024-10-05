<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TemaSeeder;
use Database\Seeders\userSeeder;
use Database\Seeders\ClusterSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(userSeeder::class);
        $this->call(ClusterSeeder::class);
        $this->call(TemaSeeder::class);
        $this->call(permasalahanSeeder::class);
        $this->call(RencanaAksiSeeder::class);
    }
}
