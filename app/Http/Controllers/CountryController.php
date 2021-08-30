<?php

namespace App\Http\Controllers;

use App\Traits\{HasList};

class CountryController extends Controller
{
    use HasList;

    public function __construct()
    {
        $this->model = \App\Models\Country::class;
    }
}
