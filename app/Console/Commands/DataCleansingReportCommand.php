<?php

namespace App\Console\Commands;

use App\DataCleanser\DataCleanser;
use Illuminate\Console\Command;

class DataCleansingReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:cleansing-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Produces a report of how clean a particular dataset is';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * For this example we'll get our data from a predefined JSON file.
         * In the real world this would arrive by other means.
         */
        $data = json_decode(file_get_contents(storage_path('app/data.json')), true);

        $cleanser = new DataCleanser($data);

        if ($results = $cleanser->analyse()) {
            foreach ($results as $index => $rows) {
                $this->info('Row ' . $index . ' has an overall dirtiness score of ' . $rows['overall_dirtiness_score']);

                foreach ($rows['dirty_data'] as $key => $data) {
                    $this->info("\t" . 'Value for field "' . $key . '" is "' . 
                        $data['value'] . '", suggested is "' . $data['suggestion'] . '"');
                }

                $this->info("\n");
            }
        }
    }
}
