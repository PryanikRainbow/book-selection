<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportData\ImportPublicBooksDataJob;

class ImportPublicBooksData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-public-books-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports books data from a CSV file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ImportPublicBooksDataJob::dispatch(base_path() . '/public/files/test_data.csv');
    }
}
