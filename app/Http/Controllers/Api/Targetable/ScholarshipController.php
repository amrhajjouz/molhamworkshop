<?php

namespace App\Http\Controllers\Api\Targetable;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Targetable\Scholarship\{RetrievingScholarshipResource , ListingScholarshipResource};
use Illuminate\Http\Request;
use App\Models\{Scholarship};

class ScholarshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor:optional');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(new ListingScholarshipResource(Scholarship::with('target')->orderBy('id', 'desc')->where(function ($q) use ($request) {
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
            return response()->json(new RetrievingScholarshipResource(Scholarship::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
