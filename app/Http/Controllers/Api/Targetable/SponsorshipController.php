<?php

namespace App\Http\Controllers\Api\Targetable;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Targetable\Sponsorship\{RetrievingSponsorshipResource , ListingSponsorshipResource};
use Illuminate\Http\Request;
use App\Models\{Sponsorship};

class SponsorshipController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth_donor');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(new ListingSponsorshipResource(Sponsorship::with('target')->orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function retrieve(Request $request , $id)
    {
        try {
            return response()->json(new RetrievingSponsorshipResource(Sponsorship::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
