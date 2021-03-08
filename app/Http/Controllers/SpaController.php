<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function index ($url = null, Request $request)
    {
        try {
            
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') { 
                return 'https';
            }
            
            if ($request->is('api/*')) return response()->json(['error' => 'API Route not found'], 500);
            
            $app_url =  url('');
            $routes = [];
            foreach(include(base_path('routes/ng.php')) as $route_name => $r) {
                $route_url = ($r[0][0] == '/') ? $r[0] : '/' . $r[0];
                $controller_path = $r[1] . '.js';
                $controller_exploded_by_slash = explode('/', $r[1]);
                $controller_name = end($controller_exploded_by_slash);
                $template_path = str_replace('.', '/', $r[2]) . '.htm';
                $template_id_exploded = explode('.', $r[2]);
                array_pop($template_id_exploded);
                $template_directory = implode('/', $template_id_exploded); //(count($a) > 0) ? implode('/', $a) : '';
                $routes[] = ['name' => $route_name, 'url' =>  $route_url , 'controller_name' => $controller_name, 'controller_path' => $controller_path, 'template_directory' => $template_directory, 'template_id' => $r[2], 'template_path' => $template_path];
            }
            
            $routes = collect($routes);
            
            foreach ($routes as $r) {
                if ($routes->where('controller_name', $r['controller_name'])->where('controller_path', '!=', $r['controller_path'])->count() > 0)
                    return response()->json(['error' => 'AngularJS Configuration Error: ' . $r['controller_name'] . ' must be a unique name for only one controller !'], 500);
                if (!file_exists(public_path() . '/ng/controllers/' . $r['controller_path']))
                    return response()->json(['error' => 'AngularJS Configuration Error: controller file of ' . $r['controller_name'] . ' is not found !'], 500);
                if (!file_exists(public_path() . '/ng/templates/' . $r['template_path']))
                    return response()->json(['error' => 'AngularJS Configuration Error: template file ' . $r['template_path'] . ' is not found !'], 500);
            }
            return view('app', ['routes' => collect($routes), 'app_url' => $app_url, 'api_url' => $app_url . '/api/']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}