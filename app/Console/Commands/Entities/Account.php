<?php

namespace App\Console\Commands\Entities;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Models\Account as AccountModel;

class Account extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:account {--company_name=} {--company_id=} {--name=}';

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
        $companyName = $this->option('company_name');
        $companyId = (int) $this->option('company_id');

        if ($companyId && $companyName) {
            $this->error("Don't use company name and company id at the same time");
            return 1;
        }

        if (!$companyId && !$companyName) {
            $this->error('Set company name or company id');
            return 1;
        }

        if ($companyId) {
            $company = Company::find($companyId);
        } elseif ($companyName) {
            $company = Company::where('name', $companyName)->first();
        }

        $name = $this->option('name');

        $account = new AccountModel(['name' => $name]);

        $company->accounts()->save($account);

        $this->info('Account created');

    }
}
