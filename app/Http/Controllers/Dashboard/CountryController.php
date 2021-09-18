<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function search(Request $request)
    {
        try {
            $countries = Country::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('name->en', 'like', '%' . $request->q . '%');
                }
            })->take(10)->get()->map(function($country) {
                return ['id'=> $country->code, 'text' => $country->name[app()->getLocale()]]; 
            });
            return response()->json($countries);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
