<?php

namespace App\Console\Commands\Dashboard\Backend;

use App\Console\Commands\Dashboard\DashboardGenerator;
use Exception;
use Illuminate\Support\Facades\Artisan;

class BackendEndGenerator extends DashboardGenerator
{
    private $choices = [
        "Controller" => false,
        "Request" => false,
        "Model" => false,
        "Migration" => false,
    ];

    public function process($name)
    {
        $words = $this->GetStringRewords($name);

        foreach ($this->choices as $key => $choice) {
            if($this->choices[$key] == false){
                continue;
            }
            switch ($key) {
                case "Model":
                    $this->RunCommand("make:model {$words['pascal']}");
                    break;
                case "Migration":
                    $this->RunCommand("make:migration create_{$words['snake']}_table");
                    break;
                case "Controller":
                    $this->createController($name);
                    break;
                case "Request":
                    $this->RunCommand("make:request {$words['pascal']}/Create{$words['pascal']}Request");
                    $this->RunCommand("make:request {$words['pascal']}/Update{$words['pascal']}Request");
                    $this->RunCommand("make:request {$words['pascal']}/Retrieve{$words['pascal']}Request");
                    $this->RunCommand("make:request {$words['pascal']}/List{$words['pascal']}Request");
                    $this->RunCommand("make:request {$words['pascal']}/Delete{$words['pascal']}Request");
            }
        }
    }

    private function RunCommand($command)
    {
        $this->command->writeln("php artisan $command");
        try {
            Artisan::call($command);
        } catch (Exception $e) {
            $this->command->writeln("<error>{$e->getMessage()}!</error>");
        }
    }

    private function createController($name)
    {
        $this->command->writeln("Trying to create a new controller");

        $calculatedWords = $this->GetStringRewords($name);

        $fileControllerName = "{$calculatedWords["pascal"]}Controller.php";

        $contents = $this->ReplaceContents("templates/controller/controller",$name);

        $path = app_path("Http/Controllers/Dashboard");

        $file = $path . "/$fileControllerName";

        try {
            $this->GenerateTheFile($path, $file, $contents);
        } catch (Exception $e) {
            $this->command->writeln("<error>{$e->getMessage()}!</error>");
        }
    }

    public function setChoices($choices)
    {
        $this->choices = $choices;
    }
}
