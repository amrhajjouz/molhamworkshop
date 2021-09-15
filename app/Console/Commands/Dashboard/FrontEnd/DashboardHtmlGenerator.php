<?php

namespace App\Console\Commands\Dashboard\FrontEnd;

use App\Console\Commands\Dashboard\DashboardGenerator;
use Illuminate\Support\Str;

class DashboardHtmlGenerator extends DashboardGenerator
{
    private $list = ["add", "list", "edit", "overview"];
    private $singleFolder = ["edit", "overview"];

    public function process(string $name)
    {
        foreach ($this->list as $item) {
            $this->createHtml($name, $item);
        }

        $this->command->writeln("-----------------Expected ROUTE--------------------");
        $this->command->writeln($this->RouteDetails($name));
    }

    private function createHtml($name, $prefix)
    {
        $templateFileName = "$prefix.htm";
        $wordsToReplace = $this->GetStringRewords($name);

        $contents = $this->ReplaceContents("templates/html/{$prefix}.htm",$name);

        $path = public_path();

        if (in_array($prefix, $this->singleFolder)) {
            $file = $path . "/ng/templates/{$wordsToReplace["singular"]}/single/$templateFileName";
            $composerDir = $path . "/ng/templates/{$wordsToReplace["singular"]}/single";
        } else {
            $file = $path . "/ng/templates/{$wordsToReplace["singular"]}/$templateFileName";
            $composerDir = $path . "/ng/templates/{$wordsToReplace["singular"]}";
        }

        $this->GenerateTheFile($composerDir, $file, $contents);
    }

    private function RouteDetails($variableName): string
    {
        $variableName = Str::of($variableName)->camel();
        $pluralVariable = Str::pluralStudly($variableName); //deductionRatio => deductionRatios
        $routeName = Str::snake($pluralVariable, '-'); //deductionRatio => deduction-ratios
        $pascalCase = Str::ucfirst($variableName); //account => Account

        return "<info>
    '$routeName' => ['$routeName', '$variableName/list{$pascalCase}Controller', '$variableName.list'],
    '$routeName.add' => ['$routeName/add', '$variableName/add{$pascalCase}Controller', '$variableName.add'],
    '$routeName.overview' => ['$routeName/:id', '$variableName/overview{$pascalCase}Controller', '$variableName.single.overview'],
    '$routeName.edit' => ['$routeName/:id/edit', '$variableName/edit{$pascalCase}Controller', '$variableName.single.edit'],
!</info>";
    }

}
