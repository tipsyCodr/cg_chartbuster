<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSlugsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates SEO slugs for all missing entries in Movies, Songs, TV Shows, and Artists';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = [
            \App\Models\Movie::class,
            \App\Models\Song::class,
            \App\Models\Artist::class,
            \App\Models\TvShow::class,
        ];

        foreach ($models as $modelClass) {
            $this->info("Generating slugs for {$modelClass}...");
            $records = $modelClass::whereNull('slug')->orWhere('slug', '')->get();
            $bar = $this->output->createProgressBar(count($records));
            $bar->start();

            foreach ($records as $record) {
                $record->timestamps = false;
                // Force marked as dirty
                $record->setAttribute('slug', 'temp');
                $record->setAttribute('slug', null);
                $record->save();
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
        }

        $this->info('Completed generating slugs successfully.');
    }
}
