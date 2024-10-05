<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class permasalahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permasalahans')->insert([
            "id" => Str::uuid(),
            // 'user_id' => "3c5430cd-e8a1-4854-96a1-af0202acd668",
            // 'erb_type_id' => "2290dc9b-eeb7-401c-99e1-498e7d842cd6",
            "unique_namespace" => "permasalahan-1",
            "permasalahan" => "Permasalahan 1",
            "sasaran" => "Sasaran Permasalahan 1",
            "indikator" => "Indikator Permasalahan 1",
            "target" => "Target Permasalahan 1",
            "created_at" => now(),
            "updated_at" => now()
        ]);
    }
}
