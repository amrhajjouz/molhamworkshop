<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest\{CreateLoanRequestRequest, UpdateLoanRequestRequest};
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Auth;

class LoanRequestController extends Controller {

    public function __construct () {
        $this->middleware('auth');
    }

    public function create (CreateLoanRequestRequest $request) {
        try {
            $loan_request = LoanRequest::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
            return response()->json($loan_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateLoanRequestRequest $request) {
        try {
            $loan_request = LoanRequest::findOrFail($request->id);
            $loan_request->update($request->validated());
            return response()->json($loan_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            $loan_request = LoanRequest::with('user')->where('id', $id)->firstOrFail();
            return response()->json($loan_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {
        try {
            $loan_request = LoanRequest::with('user')->orderBy('id', 'desc')->paginate(5);
            return response()->json($loan_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            $loan_request =  LoanRequest::find($id)->delete();
            return response()->json($loan_request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
