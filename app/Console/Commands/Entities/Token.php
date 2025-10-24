<?php

namespace App\Console\Commands\Entities;

use Illuminate\Console\Command;
use App\Models\Account;
use App\Models\Token as TokenModel;
use App\Models\TokenType;


class Token extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:token {--value=} {--token_type_name=} {--token_type_id} {--account_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = $this->option('value');
        $tokenTypeName = $this->option('token_type_name');
        $tokenTypeId = (int) $this->option('token_type_id');
        $accountId = (int) $this->option('account_id');

        if (!$token) {
            $this->error('"value" option required');
            return 1;
        }

        if (!$tokenTypeName && !$tokenTypeId) {
            $this->error('Set "token_type_name" or "token_type_id" option');
            return 1;
        }

        if (!$accountId) {
            $this->error('"account_id" option required');
            return 1;
        }

        if ($tokenTypeId && $tokenTypeName) {
            $this->error("Don't use \"token_type_name\" and \"token_type_id\" at the same time");
        }

        if ($tokenTypeName) {
            $tokenType = TokenType::where('name', $tokenTypeName)->first();

            if (!$tokenType) {
                $this->error('Invalid "token_type_name option"');
                return 1;
            }
        } elseif ($tokenTypeId) {
            $tokenType = TokenType::find($tokenTypeId);
            if (!$tokenType) {
                $this->error('Invalid "token_type_name option"');
                return 1;
            }
        }

        $account = Account::find($accountId);

        if (!$account) {
            $this->error('Invalid "account_id" option');
            return 1;
        }

        //TODO Need fixed
        // TokenModel::create([
        //     'value' => $token,
        //     'token_type_id' => $tokenType->id,
        //     'account_id' => $account->id,
        // ]);

        // $this->info('Token created');



    }
}
