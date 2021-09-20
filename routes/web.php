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

        $places[($c['capital'] == 'admin' || $c['capital'] == 'primary') ?
                  $c['admin_name'] : $c['city']] = array_merge($c, [
                  'id' => $i+1,
                  'parent_id' => null,
                  'fullname' => [
                            'ar'=>'',
                            'en'=>json_encode($c['country'] . ',' . $c['city_ascii'])
                  ],
                  'name' => [
                            'ar'=>'',
                            'en'=>json_encode($c['city_ascii'])
                  ],
                  'latitude' => $c['lat'],
                  'longitude' => $c['lng'],
                  'country_code' => $c['iso2'],
        ]);


    }

    $places = collect($places);

    $places = $places->map(function ($item, $key) use ($places) {
        if ($item['capital'] == 'minor') {
            $item['parent_id'] = (isset($places[$item['admin_name']])) ? $places[$item['admin_name']]['id'] : null;
            //dd($places[$item['admin_name']]['city_ascii']);

            $en = json_decode($places[$item['admin_name']]['fullname']['en']);
            $item['fullname'] = [
                      'ar' => '',
                      'en' => json_encode($en . ',' . $item['city_ascii'])
            ];

            //dd($item['fullname']);

        }
        return $item;

    });

    //dd($places->take(10));
  //dd($places->where('capital', 'minor')->where('country_code', 'SY')->take(30));

  //print_r($places->where('country_code', 'EG'));

          $cities = [];
    foreach ($places as $i => $v) {


          unset($v['city']);
          unset($v['city_ascii']);
          unset($v['lat']);
          unset($v['lng']);
          unset($v['country']);
          unset($v['iso2']);
          unset($v['iso3']);
          unset($v['admin_name']);
          unset($v['capital']);
          unset($v['population']);

          array_push($cities,$v);

    }
    //dd($cities);
          $cities = collect($cities);
    //dd($cities->where('name', 'Al Lādhiqīyah'));

          //print_r($cities->where('country_code', 'SY'));

    dd($cities->where('country_code', 'SY'));

});

Route::middleware('auth')->get('{url?}', [SpaController::class, 'index'])->where('url', '.*')->name('home');
