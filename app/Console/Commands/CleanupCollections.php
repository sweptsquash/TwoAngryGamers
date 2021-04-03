<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Str;

class CleanupCollections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videos:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup the collections tmp folder after 24 hours';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mediaDir = base_path() . '/media/tmp/';
        $files = scandir($mediaDir);
        $files = array_slice($files, 2, count($files));

        foreach ($files as $file) {
            $created = filemtime($mediaDir . $file);
            $createdExpire = Carbon::createFromTimestamp($created)->addHours(24);
            $now = Carbon::now();

            if ($now->greaterThan($createdExpire)) {
                unlink($mediaDir . $file);
            }
        }

        return 0;
    }
}
