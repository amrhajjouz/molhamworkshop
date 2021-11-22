<?php

namespace App\Http\Controllers\Api\Targetable;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Targetable\SmallProject\{RetrievingSmallProjectResource , ListingSmallProjectResource};
use Illuminate\Http\Request;
use App\Models\{SmallProject};

class SmallProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor:optional');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(new ListingSmallProjectResource(SmallProject::with('target')->orderBy('id', 'desc')->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function retrieve(Request $request , $id)
    {
        try {
            return response()->json(new RetrievingSmallProjectResource(SmallProject::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
