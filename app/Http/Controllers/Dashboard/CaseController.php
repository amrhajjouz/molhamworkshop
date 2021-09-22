<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Cases};
use App\Http\Requests\Target\Cases\{CreateCaseRequest, UpdateCaseRequest, ArchiveTargetRequest,  DocumentTargetRequest, HideTargetRequest, PostTargetRequest, UnArchiveTargetRequest, UnDocumentTargetRequest, UnHideTargetRequest};
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

    public function post(PostTargetRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->makePosted());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function document(DocumentTargetRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->makeDocumented());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function Undocument(UnDocumentTargetRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->makeUndocumented());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function archive(ArchiveTargetRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->makeArchived());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function unArchive(UnArchiveTargetRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->makeUnarchived());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function hide(HideTargetRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->makeAsHidden());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function Unhide(UnHideTargetRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->makeAsUnhidden());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
