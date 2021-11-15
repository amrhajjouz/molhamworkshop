<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvancePaymentRequest\{CreateAdvancePaymentRequestRequest, UpdateAdvancePaymentRequestRequest,RetrieveAdvancePaymentRequestRequest};
use App\Models\AdvancePaymentRequest;
use Illuminate\Http\Request;


class AdvancePaymentRequestController extends Controller {

    public function __construct () {
        $this->middleware('auth');
    }

    public function create (CreateAdvancePaymentRequestRequest $request) {
        try {
            $advancePaymentRequest = AdvancePaymentRequest::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

            return response()->json($advancePaymentRequest);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateAdvancePaymentRequestRequest $request) {
        try {
            $advancePaymentRequest = AdvancePaymentRequest::findOrFail($request->id);

            $advancePaymentRequest->update($request->validated());
            //dd($advancePaymentRequest);
            return response()->json($advancePaymentRequest);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            $advancePaymentRequest = AdvancePaymentRequest::with('user')->where('id', $id)->firstOrFail();
            return response()->json($advancePaymentRequest);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {
        try {
            $advancePaymentRequests = AdvancePaymentRequest::with('user')->orderBy('id', 'desc')->paginate(5);
            return response()->json($advancePaymentRequests);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            $advance_payment_requests =  AdvancePaymentRequest::find($id)->delete();
            return response()->json($advance_payment_requests);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
