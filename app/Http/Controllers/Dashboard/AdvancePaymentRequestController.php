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
            $advance_payment_request = AdvancePaymentRequest::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

            return response()->json($advance_payment_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateAdvancePaymentRequestRequest $request) {
        try {
            $advance_payment_request = AdvancePaymentRequest::findOrFail($request->id);

            $advance_payment_request->update($request->validated());
            //dd($advancePaymentRequest);
            return response()->json($advance_payment_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            $advance_payment_request = AdvancePaymentRequest::with('user')->where('id', $id)->firstOrFail();
            return response()->json($advance_payment_request);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {
        try {
            $advance_payment_requests = AdvancePaymentRequest::with('user')->orderBy('id', 'desc')->paginate(5);
            return response()->json($advance_payment_requests);

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
