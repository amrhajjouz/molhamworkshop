<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveType\{CreateLeaveTypeRequest, UpdateLeaveTypeRequest,ListLeaveTypeRequest,DeleteLeaveTypeRequest,RetrieveLeaveTypeRequest};
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller {

    public function create (CreateLeaveTypeRequest $request) {
        try {
            $leaveType = LeaveType::create($request->validated());

            return response()->json($leaveType);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateLeaveTypeRequest $request) {
        try {
            $leaveType = LeaveType::findOrFail($request->id);

            $leaveType->update($request->validated());

            return response()->json($leaveType);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(LeaveType::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $leave_type = LeaveType::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('leave_name', 'like', "%" . $request->q . "%");
                    //$q->orWhere('name->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function ($leave_type) {
                return ['id' => $leave_type->id, 'text' => $leave_type->leave_name];
            });
            return response()->json($leave_type);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list () {

        try {
            $leaveTypes = LeaveType::orderBy('id', 'asc')->paginate(5);

            return response()->json($leaveTypes);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
