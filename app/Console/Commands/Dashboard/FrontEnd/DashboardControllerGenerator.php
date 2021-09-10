<?php

namespace App\Console\Commands\Dashboard\FrontEnd;

use App\Console\Commands\Dashboard\DashboardGenerator;

class DashboardControllerGenerator extends DashboardGenerator
{
    private $list = ["add", "list", "edit", "overview"];

    public function process(string $name)
    {
        foreach ($this->list as $item) {
            $this->createController($name, $item);
        }
    }

    private function createController($name, $prefix)
    {
        $wordsToReplace = $this->GetStringRewords($name);

        $camelCaseControllerName = "$prefix{$wordsToReplace["pascal"]}Controller";

        $contents = $this->ReplaceContents("templates/js/{$prefix}",$name);

        $path = public_path();

        $file =  "$path/ng/controllers/{$wordsToReplace["singular"]}/$camelCaseControllerName.js";

        $composerDir = "$path/ng/controllers/{$wordsToReplace["singular"]}";

        $this->GenerateTheFile($composerDir, $file, $contents);
    }
}
