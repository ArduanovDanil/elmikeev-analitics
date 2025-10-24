<?php

namespace App\Console\Commands\Entities;

use Illuminate\Console\Command;
use App\Models\ApiService as ApiServiceModel;

class ApiService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:api-service {--name=}';

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

        $isTokenTypeExist = ApiServiceModel::where('name', $name)->exists();

        if($isTokenTypeExist) {
            $this->error('Api service exist');
            return 1;
        }
        
        ApiServiceModel::create([
            'name' => $name
        ]);

        $this->info('Api service created');

    }
}
