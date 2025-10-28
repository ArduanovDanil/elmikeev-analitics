<?php

namespace App\Console\Commands\Entities;

use Illuminate\Console\Command;
use App\Models\ApiService as ApiServiceModel;
use App\Models\TokenType;

class ApiService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:api-service {--name=} {--token_type_name=}';

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

        $tokenTypeName = $this->option('token_type_name');

        if (!$tokenTypeName) {
            $this->error('Option "token_type_name" required!');
            return 1;
        }

        $tokenType = TokenType::where('name', $tokenTypeName)->first();

        if (!$tokenType) {
            $this->error('Invalid token_type_name option');
            return 1;
        }

        $isApiServiceExist = ApiServiceModel::where('name', $name)->exists();

        if($isApiServiceExist) {
            $this->error('Api service exist');
            return 1;
        }

        $apiService = ApiServiceModel::create([
            'name' => $name
        ]);

        $apiService->tokenType()->attach($tokenType->id); 

        $this->info('Api service created');

    }
}
