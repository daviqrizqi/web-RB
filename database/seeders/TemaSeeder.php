<?php

namespace Database\Seeders;

use App\Models\Cluster;
use App\Models\ERBType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
      
            $clusterGeneral = Cluster::where('cluster', 'General')->first();
            $clusterTematik = Cluster::where('cluster', 'Tematik')->first();
    
            ERBType::insert([
                [
                    'id' => Str::uuid(),
                    'nama' => 'Tema 1',
                    'cluster_id' => $clusterGeneral->id,
                ],
                [
                    'id' => Str::uuid(),
                    'nama' => 'Tema 2',
                    'cluster_id' => $clusterGeneral->id,
                ],
                [
                    'id' => Str::uuid(),
                    'nama' => 'Sunting',
                    'cluster_id' => $clusterTematik->id,
                ],
                [
                    'id' => Str::uuid(),
                    'nama' => 'Kemiskinan',
                    'cluster_id' => $clusterTematik->id,
                ],
                // tambahkan tema lainnya disini
            ]);
        
    }
}