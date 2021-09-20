<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index (Request $request , $url = null)
    {
        try {

            if ($request->is('dashboard/api/*')) return response()->json(['error' => 'API Route not found'], 500);

            $appUrl =  url('');
            $routes = [];
            foreach(include(base_path('routes/dashboard/ng.php')) as $routeName => $r) {
                $routeUrl = ($r[0][0] == '/') ? $r[0] : '/' . $r[0];
                $controllerPath = $r[1] . '.js';
                $controllerExplodedBySlash = explode('/', $r[1]);
                $controllerName = end($controllerExplodedBySlash);
                $templatePath = str_replace('.', '/', $r[2]) . '.htm';
                $templateIdExploded = explode('.', $r[2]);
                array_pop($templateIdExploded);
                $templateDirectory = implode('/', $templateIdExploded); //(count($a) > 0) ? implode('/', $a) : '';
                $routes[] = ['name' => $routeName, 'url' =>  $routeUrl , 'controller_name' => $controllerName, 'controller_path' => $controllerPath, 'template_directory' => $templateDirectory, 'template_id' => $r[2], 'template_path' => $templatePath];
            }

            $routes = collect($routes);

            foreach ($routes as $r) {
                if ($routes->where('controller_name', $r['controller_name'])->where('controller_path', '!=', $r['controller_path'])->count() > 0) {
                    $existsIn = $routes->where('controller_name', $r['controller_name'])->pluck(array('controller_path'))->toArray();
                    return response()->json(['error' => 'AngularJS Configuration Error: ' . $r['controller_name'] . ' must be a unique name for only one controller ! check ' . implode(" and ", $existsIn)], 500);
                }if (!file_exists(public_path() . '/ng/controllers/' . $r['controller_path']))
                    return response()->json(['error' => 'AngularJS Configuration Error: controller file of ' . $r['controller_path'] . ' is not found !'], 500);
                if (!file_exists(public_path() . '/ng/templates/' . $r['template_path']))
                    return response()->json(['error' => 'AngularJS Configuration Error: template file ' . $r['template_path'] . ' is not found !'], 500);
            }

            $locales = collect([]);

            foreach (['ar', 'en', 'fr', 'de', 'tr', 'es'] as $l) $locales[] = ['code' => $l, 'name' => getLocaleName($l), 'dir' => ($l == 'ar') ? 'rtl' : 'ltr', 'align' => ($l == 'ar') ? 'right' : 'left'];

            return view('app', ['routes' => collect($routes), 'appUrl' => $appUrl, 'apiUrl' => $appUrl . '/dashboard/api/', 'locales' => $locales]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
