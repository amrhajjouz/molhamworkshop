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
            $travel_request = TravelRequest::create($request->all());
            return response()->json($travel_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateTravelRequestRequest $request) {
        try {
            $travel_request = TravelRequest::findOrFail($request->id);
            $travel_request->update($request->validated());
            return response()->json($travel_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {

        try {
            $travel_request = TravelRequest::with(['user'])->where('id', $id)->firstOrFail();
            return response()->json($travel_request);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {
        try {
            $travel_requests = TravelRequest::with('user')->orderBy('id', 'desc')->paginate(5);
            return response()->json($travel_requests);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            $travel_request =  TravelRequest::find($id)->delete();
            return response()->json($travel_request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
