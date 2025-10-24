<?php

namespace App\Console\Commands\Entities;

use Illuminate\Console\Command;
use App\Models\TokenType as TokenTypeModel;

class TokenType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:token-type {--name=}';

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

        $isTokenTypeExist = TokenTypeModel::where('name', $name)->exists();

        if($isTokenTypeExist) {
            $this->error('Company exist');
            return 1;
        }
        
        TokenTypeModel::create([
            'name' => $name
        ]);

        $this->info('Token type created');

    }
}
