<?php

namespace App\Console\Commands;

use App\Console\Commands\Dashboard\Backend\BackendEndGenerator;
use App\Console\Commands\Dashboard\FrontEnd\FrontEndGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * @property FrontEndGenerator frontEndGenerator
 * @property BackendEndGenerator backendEndGenerator
 */
class GenerateDashboardCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dashboard-crud {name} {--f|full}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate crud components for the dashboard';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FrontEndGenerator $frontEndGenerator, BackendEndGenerator $backendEndGenerator)
    {
        parent::__construct();
        $this->frontEndGenerator = $frontEndGenerator;
        $this->backendEndGenerator = $backendEndGenerator;
    }

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $name = Str::singular($this->argument('name'));
        $fullChoice = $this->option('full');

        $choices = [
            "Controller" => $fullChoice,
            "Request" => $fullChoice,
            "Model" => $fullChoice,
            "Migration" => $fullChoice,
            "NG-Template" => $fullChoice,
        ];

        foreach ($choices as $key => $choice) {
            if ($fullChoice || $this->confirm("Do you want to add {$key}?", true)) {
                $choices[$key] = true;
            }
        }

        $this->backendEndGenerator->setChoices($choices);
        $this->backendEndGenerator->process($name);

        if ($choices["NG-Template"]) {
            $this->frontEndGenerator->handle($name);
        }
    }
}
