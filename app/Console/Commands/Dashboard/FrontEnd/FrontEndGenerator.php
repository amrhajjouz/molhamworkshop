<?php

namespace App\Console\Commands\Dashboard\FrontEnd;

class FrontEndGenerator
{
    private $controllerGenerator;
    private $dashboardHtmlGenerator;

    public function __construct(DashboardControllerGenerator $controllerGenerator, DashboardHtmlGenerator $dashboardHtmlGenerator)
    {
        $this->controllerGenerator = $controllerGenerator;
        $this->dashboardHtmlGenerator = $dashboardHtmlGenerator;
    }

    public function handle($className)
    {
        $this->controllerGenerator->process($className);
        $this->dashboardHtmlGenerator->process($className);
    }
}
