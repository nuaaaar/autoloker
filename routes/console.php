<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\Api\AccountDeletionFileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command('accounts:purge-deletion-files', function (AccountDeletionFileService $files) {
    DB::table('account_deletion_files')->orderBy('id')->chunkById(100, function ($rows) use ($files) {
        $files->purge($rows->pluck('id')->all());
    });

    return DB::table('account_deletion_files')->exists() ? 1 : 0;
})->purpose('Retry pending account deletion file cleanup');

Schedule::command('accounts:purge-deletion-files')->everyMinute()->withoutOverlapping();
