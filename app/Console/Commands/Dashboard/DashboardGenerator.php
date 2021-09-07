<?php

namespace App\Console\Commands\Dashboard;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class DashboardGenerator implements IDashboardGenerator
{
    protected $command;
    private $files;

    function __construct(Filesystem $files, ConsoleOutput $command)
    {
        $this->files = $files;
        $this->command = $command;
    }

    public function GenerateTheFile(string $composerDir, string $file, string $contents): bool
    {
        if ($this->files->isDirectory($composerDir)) {
            if ($this->files->isFile($file)) {
                $this->command->writeln("<error>$file Already exists!</error>");
                return false;
            }
        } else {
            $this->files->makeDirectory($composerDir, 0777, true, true);
        }

        if (!$this->files->put($file, $contents)) {
            $this->command->writeln("<error>Something went wrong!</error>");
            return false;
        }

        $this->command->writeln("<info>$file generated!</info>");

        return true;
    }

    public function ReplaceContents($path, $name): string
    {
        $path = Storage::disk('public')->path($path);
        $file = File::get($path);

        $wordsToReplace = $this->GetStringRewords($name);
        foreach ($wordsToReplace as $key=> $word){
            $file = str_replace('{'.$key.'}', $word, $file);
        }

        return $file;
    }

    public function GetStringRewords($singular): array
    {
        $singular = Str::of(Str::singular($singular))->camel() ;
        $singularPascalCase = Str::ucfirst($singular);
        $plural = Str::pluralStudly($singular);
        $pluralCamelCase = Str::pluralStudly($singular);
        $pluralPascalCase = Str::ucfirst($pluralCamelCase);
        $kebabPlural = Str::kebab($pluralCamelCase);
        $snakeCase = Str::snake($pluralCamelCase);
        $data = [
            "singular" => $singular, //deduction-ratios = >deductionRatios
            "plural" => $plural,//account => accounts
            "plural_camel_case" => $pluralCamelCase,//deductionRatio => deductionRatios
            "kebab" => $kebabPlural,//deductionRatio => deduction-ratios
            "snake" => $snakeCase,//deductionRatio => deduction_ratios
            "pascal" => $singularPascalCase, //account => Accounts
            "pascal_plural" => $pluralPascalCase, //account => Account
        ];

        return $data;
    }
}
