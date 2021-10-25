<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Exception;

class CountryController extends Controller
{
    public function list()
    {
        try {
            return response()->json(Country::all());
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
