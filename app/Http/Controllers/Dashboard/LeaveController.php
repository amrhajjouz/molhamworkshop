<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Leave\{CreateLeaveRequest, UpdateLeaveRequest, UpdateStatusLeaveRequest};
use App\Models\Leave;

class LeaveController extends Controller {

    public function create (CreateLeaveRequest $request) {
        try {
            $leave = Leave::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
            return response()->json($leave);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateLeaveRequest $request) {
        try {
            $leave = Leave::findOrFail($request->id);

            $leave->update($request->validated());

            return response()->json($leave);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function status_update (UpdateStatusLeaveRequest $request) {
        try {
            $leave = Leave::findOrFail($request->id);

            $leave->update($request->validated());

            return response()->json($leave);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {

            return response()->json(Leave::with('leaveType')->where('id', $id)->firstOrFail());
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function show ($id) {
        try {

            return response()->json(Leave::with('leaveType', 'user')->where('id', $id)->firstOrFail());
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    // get Leaves for user login
    public function list () {

        try {
            $leaves = Leave::with('leaveType', 'user')->where('user_id', auth()->id())->orderBy('id', 'desc')->paginate(5);

            return response()->json($leaves);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    // get all Leaves for admin login
    public function leaves () {

        try {
            $leaves = Leave::with('leaveType', 'user')->orderBy('id', 'desc')->paginate(5);

            return response()->json($leaves);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $member = Leave::find($id)->delete();
            return response()->json($member);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
