<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function list(Request $request)
    {
        try {
            $countries = Country::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('name->en', 'like', '%' . $request->q . '%');
                }
            })->get();
            return response()->json($countries);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
