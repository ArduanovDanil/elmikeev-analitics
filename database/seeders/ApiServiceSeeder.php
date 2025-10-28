<?php

namespace Database\Seeders;

use App\Models\ApiService;
use App\Models\TokenType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApiService::factory()->count(10)->create();
    }
}
