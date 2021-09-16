<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\{CreateCurrencyRequest, UpdateCurrencyRequest};
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller {

    public function create (CreateCurrencyRequest $request) {
        try {
            $currency = Currency::create($request->validated());

            return response()->json($currency);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateCurrencyRequest $request) {
        try {
            $currency = Currency::findOrFail($request->id);

            $currency->update($request->validated());

            return response()->json($currency);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(Currency::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {

        try {
            $currencies = Currency::orderBy('id', 'desc')->where(function($q) use ($request){
                    if ($request->has('q')) {
                              $q->where('name', 'like', '%' . $request->q . '%');
                              $q->orWhere('code', 'like', '%' . $request->q . '%');
                              $q->orWhere('symbol', 'like', '%' . $request->q . '%');
                              $q->orWhere('symbol_native', 'like', '%' . $request->q . '%');
                    }
            })->paginate(10)->withQueryString();

            return response()->json($currencies);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function remove ($id) {
          try {
              Currency::destroy($id);
              return response()->status(200);
          } catch (\Exception $e) {
              return response(['error' => $e->getMessage()], 500);
          }
      }
}
