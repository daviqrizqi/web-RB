<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class RencanaAksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('rencana_aksis')->insert([
            "id" => Str::uuid(),
            // 'user_id' => "3c5430cd-e8a1-4854-96a1-af0202acd668",
            // 'permasalahan_id' => 1,
            "unique_namespace" => "permasalahan-1",
            "rencana_aksi" => "Rencana Aksi Permasalahan 1",
            "indikator" => "Angka Kesehatan",
            "satuan" => "%",
            "koordinator" => "dinas kesehatan",
            "pelaksana" => "dinas kesehatan",
            "created_at" => now(),
            "updated_at" => now()
        ]);
    }
}
