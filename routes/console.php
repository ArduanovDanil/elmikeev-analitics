<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('app:parse-api --endpoint=incomes --account_id=1')->twiceDaily();
Schedule::command('app:parse-api --endpoint=orders --account_id=1')->twiceDaily();
Schedule::command('app:parse-api --endpoint=sales --account_id=1')->twiceDaily();
Schedule::command('app:parse-api --endpoint=stocks --account_id=1')->twiceDaily();

