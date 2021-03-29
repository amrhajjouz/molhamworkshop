<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList};


class CountryController extends BaseController {

    use HasList;

    public function __construct(){
        
        $this->model = \App\Models\Country::class;
    }
    
    
}