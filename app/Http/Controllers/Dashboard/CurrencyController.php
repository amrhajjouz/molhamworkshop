<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Exception;

class CurrencyController extends Controller
{
    public function list()
    {
        try {
            return response()->json(Currency::all());
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function getRate($currency)
    {
        try {
            return response()->json(Currency::where(['code' => $currency])->firstOrFail()->rate);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
