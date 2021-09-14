<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function list (Request $request)
    {
        try {
            return response()->json(Country::all());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
