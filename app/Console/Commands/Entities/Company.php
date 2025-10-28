<?php

namespace App\Console\Commands\Entities;

use Illuminate\Console\Command;
use App\Models\Company as CompanyModel;

class Company extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:company {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $name = $this->option('name');

        if(!$name) {
            $this->error('Option "name" required!');
            return 1;
        }

        $isCompanyExist = CompanyModel::where('name', $name)->exists();

        if($isCompanyExist) {
            $this->error('Company exist');
            return 1;
        }
        
        CompanyModel::create([
            'name' => $name
        ]);

        $this->info('Company created');

    }
}
