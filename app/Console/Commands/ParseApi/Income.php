<?php

namespace App\Console\Commands\ParseApi;

use App\Models\Income as IncomeModel;
use Faker\Core\Barcode;
use Illuminate\Console\Command;

class Income extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:income';

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

        $newIncome = IncomeModel::create(
            [
                'income_id' => 123,
                'number' => 55443,
                'date' => now(),
                'last_change_date' => now(),
                'supplier_article' => 'f4flf23498fs9f8s',
                'tech_size' => '66e7dff9f98764da',
                'barcode' => 12313,
                'quantity' => 0,
                'total_price' => 0,
                'date_close' => now(),
                'warehouse_name' => 'Электросталь',
                'nm_id' => 234442,
            ]
        );


        dd($newIncome);

        $income = IncomeModel::all();
        dd($income);
    }
}
