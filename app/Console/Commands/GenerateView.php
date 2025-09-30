<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:view {name : The name of the view file} {--layout= : The layout to use for the view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new view file in the resources/views directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the name of the view
        $name = $this->argument('name');
        $layout = $this->option('layout') ?: 'layouts.app';

        // Create the file path
        $path = resource_path('views/' . str_replace('.', '/', $name) . '.blade.php');

        // Check if the file already exists
        if (File::exists($path)) {
            $this->error("The view file already exists at {$path}");
            return;
        }

        // Ensure the directory exists
        File::ensureDirectoryExists(dirname($path));

        // Generate the file content
        $content = <<<HTML
@extends('$layout')

@section('content')
    <h1>$name View</h1>
    <p>This is a placeholder for the $name view.</p>
@endsection
HTML;

        // Create the file
        File::put($path, $content);

        $this->info("View file created at {$path}");
    }
}
