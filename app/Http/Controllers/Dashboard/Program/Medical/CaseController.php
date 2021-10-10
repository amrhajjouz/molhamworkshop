<?php

namespace App\Http\Controllers\Dashboard\Program\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Cases, Target};
use App\Http\Requests\Program\Medical\Cases\{
    CreateMedicalCaseRequest,
    UpdateMedicalCaseRequest,
    ArchiveMedicalCaseRequest,
    DocumentMedicalCaseRequest,
    HideMedicalCaseRequest,
    UnarchiveMedicalCaseRequest,
    UndocumentMedicalCaseRequest,
    UnhideMedicalCaseRequest,
    UpdateMedicalCaseContentsRequest,
    ReadyToPublishMedicalCaseRequest,
};
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
            })->paginate(10)->withQueryString()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function create(CreateMedicalCaseRequest $request)
    {
        try {
            $case = Cases::create($request->validated());
            return response()->json(new SingleCaseResource($case));
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

    public function update(UpdateMedicalCaseRequest $request)
    {
        try {
            $case = Cases::findOrFail($request->id);
            $case->update($request->validated());
            return response()->json(new SingleCaseResource($case));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateCaseContents(UpdateMedicalCaseContentsRequest $request, $id)
    {
        try {
            $case = Cases::findOrFail($id);
            $case->target->updateContentFields($request->validated());
            return response()->json(new SingleCaseResource($case));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    ////////////////////// Case Target's Actions /////////////////////


    public function markAsDocumented(DocumentMedicalCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsDocumented());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsUndocumented(UndocumentMedicalCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsUndocumented());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsArchived(ArchiveMedicalCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsArchived());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsUnarchived(UnarchiveMedicalCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsUnarchived());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsHidden(HideMedicalCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsHidden());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsVisible(UnhideMedicalCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsVisible());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsReadyToPublish(ReadyToPublishMedicalCaseRequest $request, $id)
    {
        try {
            return response()->json(Cases::findOrFail($id)->markAsReadyToPublish());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
