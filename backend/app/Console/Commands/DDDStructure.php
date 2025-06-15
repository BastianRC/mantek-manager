<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DDDStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ddd {context} {entity?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create base DDD + Hexagonal structure for a given context and entity in src/';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $entity = Str::studly($this->argument('entity'));
        $context = $this->argument('context') ? Str::studly($this->argument('context')) : null;

        $basePath = $context
            ? base_path("src/{$context}/{$entity}")
            : base_path("src/{$entity}");

        if (File::exists($basePath)) {
            $this->error("The module already exists at " . str_replace(base_path() . '/', '', $basePath));
            return;
        }

        $folders = [
            'Application/DTOs',
            'Application/UseCases',
            'Domain/Entity',
            'Domain/Repository',
            'Domain/ValueObject',
            'Infrastructure/Http/Controllers',
            'Infrastructure/Http/Requests',
            'Infrastructure/Persistence/Eloquent/Models',
            'Infrastructure/Persistence/Eloquent/Repositories',
            'Providers',
        ];

        foreach ($folders as $folder) {
            File::makeDirectory("{$basePath}/{$folder}", 0755, true);
        }

        $this->info("DDD structure created at " . str_replace(base_path() . '/', '', $basePath));
    }
}
