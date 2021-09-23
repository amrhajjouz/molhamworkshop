<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Cases};
use App\Http\Requests\Target\Cases\{CreateCaseRequest, UpdateCaseRequest, ArchiveCaseRequest,  DocumentCaseRequest, HideCaseRequest, PostCaseRequest, UnarchiveCaseRequest, UndocumentCaseRequest, UnhideCaseRequest};
use App\Http\Resources\Target\Cases\Dashboard\CasesResource;

class CaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(Cases::with('target')->orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('serial_number', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function create(CreateCaseRequest $request)
    {
        try {
            $case = Cases::create($request->validated());
            return response()->json(new CasesResource($case));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(new CasesResource(Cases::findOrFail($id)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateCaseRequest $request)
    {
        try {
            $case = Cases::findOrFail($request->id);
            $case->update($request->validated());
            return response()->json(new CasesResource($case));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    ////////////////////// Case Target's Actions /////////////////////

    public function markAsPosted(PostCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsPosted());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsDocumented(DocumentCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsDocumented());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsUndocumented(UndocumentCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsUndocumented());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsArchived(ArchiveCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsArchived());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsUnarchived(UnarchiveCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsUnarchived());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsHidden(HideCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsHidden());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsVisible(UnhideCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsVisible());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
