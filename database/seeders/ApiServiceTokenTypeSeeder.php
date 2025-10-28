<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiServiceTokenTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apiServices = DB::table('api_services')->get();
        $tokenTypes = DB::table('token_types')->get();
        foreach ($apiServices as $apiService) {
            $tokenType = $tokenTypes->random();
            DB::table('api_service_token_type')->insert([
                    'api_service_id' => $apiService->id,
                    'token_type_id' => $tokenType->id,
            ]);
        }
    }
}
