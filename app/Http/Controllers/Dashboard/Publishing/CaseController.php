<?php

namespace App\Http\Controllers\Dashboard\Publishing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Cases};
use App\Http\Requests\Publishing\Cases\{PublishCaseRequest , ProofreadCaseRequest};
use App\Http\Resources\Dashboard\Program\Medical\Cases\{CasesListResource, SingleCaseResource};

class CaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(new CasesListResource(Cases::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('serial_number', 'like', '%' . $request->q . '%');
                }
            })
            ->whereHas('target' ,  function($query){
                 $query->where('ready_to_publish' ,'=', 1);
            })
            ->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    // public function retrieve($id)
    // {
    //     try {
    //         return response()->json(new SingleCaseResource(Cases::findOrFail($id)));
    //     } catch (\Exception $e) {
    //         return ['error' => $e->getMessage()];
    //     }
    // }

    // public function update(UpdateCaseContentsRequest $request)
    // {
    //     try {
    //         $case = Cases::findOrFail($request->id);
    //         $case->target->update($request->validated());
    //         return response()->json(new SingleCaseResource($case));
    //     } catch (\Exception $e) {
    //         return ['error' => $e->getMessage()];
    //     }
    // }

    public function markAsPublished(PublishCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsPosted());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function markAsrofread(ProofreadCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsProofread());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
