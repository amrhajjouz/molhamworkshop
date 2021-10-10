<?php

namespace App\Http\Controllers\Dashboard\Translation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Translation\Cases\ProofreadTranslationCaseRequest;
use App\Models\{Cases};
use App\Http\Requests\Translation\Cases\{UpdateTranslationCaseContentsRequest};
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
            return response()->json(new CasesListResource(Cases::with('target')->orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('serial_number', 'like', '%' . $request->q . '%');
                }
            })
                ->whereHas('target',  function ($query) {
                    $query->where('ready_to_publish', '=', 1);
                    $query->where('published_at', '!=', null);
                })->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function retrieve($id)
    {
        try {
            return response()->json(new SingleCaseResource(Cases::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateTranslationCaseContentsRequest $request)
    {
        try {
            $case = Cases::findOrFail($request->id);
            $case->target->updateContentFields($request->validated());
            return response()->json(new SingleCaseResource($case));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsProofread(ProofreadTranslationCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsProofread('en'));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
