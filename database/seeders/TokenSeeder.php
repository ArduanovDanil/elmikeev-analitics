<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Token;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $accounts = DB::table('accounts')
        ->select('id', 'company_id', 'name')
        ->get();

        $tokenTypes = DB::table('token_types')->get();
        $groupedAccounts = $accounts->groupBy('company_id');

        $groupedAccounts->each(function ($items, $key) use ($tokenTypes) {
            $items->each(function ($account, $key) use ($tokenTypes) {
                $token = Token::factory()->make([
                    'token_type_id' => $tokenTypes[$key]->id,
                    'account_id' => $account->id,
                ]);
                $token->save();
            });

        });
    }
}
