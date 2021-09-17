<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Cases};
use App\Http\Requests\Target\Cases\{CreateCaseRequest, UpdateCaseRequest};
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
            return response()->json(Cases::orderBy('id', 'desc')->where(function ($q) use ($request) {
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
}
