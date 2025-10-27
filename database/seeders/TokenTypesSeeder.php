<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokenTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['bearer', 'api-key', 'login and password'];
        foreach ($names as $name) {
            DB::table('token_types')->insert(['name' => $name]);
        }
        
    }
}
