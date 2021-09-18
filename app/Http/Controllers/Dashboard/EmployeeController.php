<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\{CreateEmployeeRequest, UpdateEmployeeRequest,ListEmployeeRequest,DeleteEmployeeRequest,RetrieveEmployeeRequest};
use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller {

 
    
    public function create (CreateEmployeeRequest $request) {
        Log::info('Showing the user profile for user: '.$request);
        try {
            $employee = Employee::create($request->all());

            return response()->json($employee);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateEmployeeRequest $request) {
        try {
            $employee = Employee::findOrFail($request->id);

            $employee->update($request->all());

            return response()->json($employee);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id, RetrieveEmployeeRequest $request) {
        try {
            return response()->json(Employee::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (ListEmployeeRequest $request) {

        try {
            // $search_query = ($request->has('q') ? [['first_name', 'like', '%' . $request->q . '%']] : null);
            
            // $employees = Employee::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();
            // // $employees = Employee::orderBy('id', 'desc')->paginate(5);

            // return response()->json($employees);

            return response()->json(Employee::orderBy('id', 'desc')->where(function($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('first_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('last_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('occupation', 'like', '%' . $request->q . '%');
                    $q->orWhere('phone', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}