<?php

namespace App\Http\Controllers\Api\Targetable;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Targetable\Campaign\{RetrievingCampaignResource , ListingCampaignResource};
use Illuminate\Http\Request;
use App\Models\{Campaign};

class CampaignController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth_donor');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(new ListingCampaignResource(Campaign::with('target')->orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function retrieve(Request $request , $id)
    {
        try {
            return response()->json(new RetrievingCampaignResource(Campaign::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
