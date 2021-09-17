<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\SpaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/cities_seeder', function () {
    
    $csv = collect(getCombinedCsv (base_path('/init_data/worldcities.csv')));
    $places = [];
    
    foreach ($csv as $i => $c) {
        $places[($c['capital'] == 'admin' || $c['capital'] == 'primary') ? $c['admin_name'] : $c['city']] = array_merge($c, ['id' => $i+1, 'parent_id' => null]);
    }
    
    $places = collect($places);
    
    /*foreach ($places as $i => $c) {
        if ($c['capital'] == 'minor') {
            $places[$i]['parent_id'] = (isset($places[$c['admin_name']])) ? $places[$c['admin_name']]['id'] : null;
        }
    }*/
    
    
    $places = $places->map(function ($item, $key) use ($places) {
        if ($item['capital'] == 'minor') {
            //if ($key == 'Jablah');
            $item['parent_id'] = (isset($places[$item['admin_name']])) ? $places[$item['admin_name']]['id'] : null;
        }
        return $item;
    });    

    dd($places->where('iso2', 'SY'));
    
    return ;    
    
});

Route::middleware('auth')->get('{url?}', [SpaController::class, 'index'])->where('url', '.*')->name('home');
