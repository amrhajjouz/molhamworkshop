<?php

namespace App\Http\Controllers\Api\Targetable;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Targetable\Project\{RetrievingProjectResource , ListingProjectResource};
use Illuminate\Http\Request;
use App\Models\{Project};

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor:optional');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(new ListingProjectResource(Project::with('target')->orderBy('id', 'desc')->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function retrieve(Request $request , $id)
    {
        try {
            return response()->json(new RetrievingProjectResource(Project::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
