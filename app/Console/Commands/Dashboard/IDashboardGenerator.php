<?php

namespace App\Console\Commands\Dashboard;

interface IDashboardGenerator
{
    public function process(string $name);
}
