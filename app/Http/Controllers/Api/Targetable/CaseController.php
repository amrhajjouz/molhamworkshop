<?php

namespace App\Http\Controllers\Api\Targetable;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Targetable\Cases\{ListingCaseResource , RetrievingCaseResource};
use App\Models\{Cases};

class CaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor:optional');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(new ListingCaseResource(Cases::with('target')->orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('serial_number', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function retrieve(Request $request , $id)
    {
        try {
            return response()->json(new RetrievingCaseResource(Cases::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
