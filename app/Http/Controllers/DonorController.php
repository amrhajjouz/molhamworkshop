<?php

namespace App\Http\Controllers;

use App\Http\Requests\Donor\UpdateDonorRequest;
use App\Models\Donor;
use Illuminate\Http\Request;
use App\Http\Requests\Donor\CreateDonorRequest;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
{

    public function create(CreateDonorRequest $request)
    {
        try {
            $data = $request->validated();
            $data["password"] = Hash::make($request->password);
            $donor = Donor::create($data);
            $donor->activityLogs()->create(["activity_name" => "create_donor", "actor_type" => "user", "actor_id" => null, "metadata" => null]);
            return response()->json($donor);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateDonorRequest $request)
    {
        try {
            $donor = Donor::findOrFail($request->id);
            $input = $request->validated();
            if (isset($input["password"])) {
                $input["password"] = Hash::make($request->password);
            }
            $donor->update($input);
            $donor->activityLogs()->create(["activity_name" => "update_donor", "actor_type" => "user", "actor_id" => null, "metadata" => null]);
            $donor->eventLogs()->create(["event_name" => "update_donor", "metadata" => null, 'activity_name' => "update_donor"]);
            return response()->json($donor);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            $donor = Donor::findOrFail($id);
            return response()->json($donor);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);
            $donors = Donor::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();
            return response()->json($donors);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listActivityLogs(Request $request, Donor $donor)
    {
        try {
            $activities = $donor->activityLogs()
                ->with(['actor'])
                ->join('activities AS A', 'activity_logs.activity_id', 'A.id')
                ->select('activity_logs.*', 'A.name AS activity_name')
                ->where(function ($q) use ($request) {
                    if ($request->has('q')) {
                        $q->where('name', 'like', '%' . $request->q . '%');
                        $q->orWhere('actor_type', 'like', '%' . $request->q . '%');
                        $q->orWhere('A.name', 'like', '%' . $request->q . '%');
                    }
                })->paginate(5)->withQueryString();
            return response()->json($activities);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function listEventLogs(Request $request, Donor $donor)
    {
        try {
            $events = $donor->eventLogs()
                ->join('events AS EV', 'event_logs.event_id', 'EV.id')
                // ->leftJoin('activities AS AC', 'event_logs.activity_id', 'AC.id')
                ->select('event_logs.*', 'EV.name AS event_name')
                ->where(function ($q) use ($request) {
                    if ($request->has('q')) {
                        $q->where('name', 'like', '%' . $request->q . '%');
                        $q->orWhere('EV.name', 'like', '%' . $request->q . '%');
                        // $q->orWhere('AC.name', 'like', '%' . $request->q . '%');
                    }
                })->paginate(5)->withQueryString();
            return response()->json($events);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
