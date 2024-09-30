<?php

namespace Database\Seeders;

use App\Models\Cluster;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cluster::insert([
            [
                'id' => Str::uuid(),
                'cluster' => 'General',
            ],
            [
                'id' => Str::uuid(),
                'cluster' => 'Tematik',
            ],
        ]);
    }
}
