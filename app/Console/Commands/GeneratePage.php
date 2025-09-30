<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GeneratePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:page {name : The name of the page file} {--layout= : The layout to use for the view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generate views/pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
         // Get the name of the view
         $name = $this->argument('name');
         $layout = $this->option('layout') ?: 'layouts.app';

         // Create the file path
         $path = resource_path('views/pages/' . str_replace('.', '/', $name) . '.blade.php');

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
