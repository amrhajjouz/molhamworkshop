<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Cases};
use App\Http\Requests\Target\Cases\{CreateCaseRequest, UpdateCaseRequest};

class CaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(CreateCaseRequest $request)
    {
        try {
            $data = $request->validated();
            $data['serial_number'] = getCaseSerialNumber();
            $case = new Cases();
            $case->beneficiary_name = $data['beneficiary_name'];
            $case->serial_number = getCaseSerialNumber(); //generate unique number 
            $case->country_code = $data['country_code'];
            $case->status = $data['status'];

            $options = ['target' => $data['target']]; // will saved in parent target or as a relation for this model

            $case->save($options);
            return response()->json($case);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            $case =  Cases::findOrFail($id);
            $caseArray  = $case->toArray();
            $locale = app()->getLocale();
            $target = $case->target;
            $response = array_merge($caseArray, [
                'country' => [
                    'name' => $case->country->name[$locale],
                ],
                'target' => [
                    'required' => $target->required,
                    'beneficiaries_count' => $target->beneficiaries_count,
                    'documented' => $target->documented,
                    'hidden' => $target->hidden,
                    'archived' => $target->archived,
                    'category'=> [
                        'name' => $target->category->name ,
                    ]
                ]
            ]);
            return response()->json($response);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateCaseRequest $request)
    {
        try {

            $data = $request->validated();
            $case = Cases::findOrFail($request->id);

            $case->beneficiary_name = $data['beneficiary_name'];
            $case->country_code = $data['country_code'];
            $case->status = $data['status'];
            unset($data['target']['category']);
            $options = ['target' => $data['target']];
            $case->save($options);
            return response()->json($case);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $cases = Cases::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('serial_number', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString();
            return response()->json($cases);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
