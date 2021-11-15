<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelRequest\{CreateTravelRequestRequest, UpdateTravelRequestRequest};
use App\Models\TravelRequest;
use Illuminate\Http\Request;
use Auth;

class TravelRequestController extends Controller {

    public function __construct () {
        $this->middleware('auth');
    }

    public function create (CreateTravelRequestRequest $request) {
        $request->merge(['user_id'=>auth()->id()]);
        try {
            $travelRequest = TravelRequest::create($request->all());
            return response()->json($travelRequest);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateTravelRequestRequest $request) {
        try {
            $travelRequest = TravelRequest::findOrFail($request->id);
            $travelRequest->update($request->validated());
            return response()->json($travelRequest);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {

        //$x = TravelRequest::find(1)->days;
        //dd($x);
        try {
            $travelRequest = TravelRequest::with(['user'])->where('id', $id)->firstOrFail();
            //dd($travelRequest->days);
            return response()->json($travelRequest);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {
        try {
            $travelRequests = TravelRequest::with('user')->orderBy('id', 'desc')->paginate(5);
            return response()->json($travelRequests);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            $travel_requests =  TravelRequest::find($id)->delete();
            return response()->json($travel_requests);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
