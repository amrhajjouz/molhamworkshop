<?php

namespace App\Http\Controllers\Api\Targetable;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Targetable\Fundraiser\{RetrievingFundraiserResource , ListingFundraiserResource};
use Illuminate\Http\Request;
use App\Models\{Fundraiser};

class FundraiserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth_donor');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(new ListingFundraiserResource(Fundraiser::with('target')->orderBy('id', 'desc')->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function retrieve(Request $request , $id)
    {
        try {
            return response()->json(new RetrievingFundraiserResource(Fundraiser::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
