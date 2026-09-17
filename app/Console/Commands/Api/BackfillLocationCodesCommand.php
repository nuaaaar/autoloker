<?php

namespace App\Console\Commands\Api;

use App\Services\Api\LocationCodeBackfillService;
use Illuminate\Console\Command;
use InvalidArgumentException;

class BackfillLocationCodesCommand extends Command
{
    protected $signature = 'profiles:backfill-location-codes
                            {--table= : Limit the backfill to one profile table}
                            {--chunk=500 : Number of profiles processed per batch}';

    protected $description = 'Backfill profile location codes from stored location values';

    public function handle(LocationCodeBackfillService $backfill): int
    {
        try {
            $processed = $backfill->backfill(
                $this->option('table'),
                (int) $this->option('chunk'),
            );
        } catch (InvalidArgumentException $exception) {
            $this->error($exception->getMessage());

            return self::INVALID;
        }

        foreach ($processed as $tableName => $count) {
            $this->line(sprintf('%s: %d profiles processed', $tableName, $count));
        }

        $this->info('Location-code backfill completed.');

        return self::SUCCESS;
    }
}
