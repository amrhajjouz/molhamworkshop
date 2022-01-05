<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamOffice\{CreateTeamOfficeRequest, UpdateTeamOfficeRequest,ListTeamOfficeRequest,DeleteTeamOfficeRequest,RetrieveTeamOfficeRequest};
use App\Models\TeamOffice;
use Illuminate\Http\Request;

class TeamOfficeController extends Controller {

    public function create (CreateTeamOfficeRequest $request) {
        try {
            $team_office = TeamOffice::create($request->validated());

            return response()->json($team_office);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateTeamOfficeRequest $request) {
        try {
            $team_office = TeamOffice::findOrFail($request->id);

            $team_office->update($request->validated());

            return response()->json($team_office);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(TeamOffice::with('user', 'place')->findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {

        try {
            return response()->json(TeamOffice::with('user', 'place')->orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        try {
            $offices = TeamOffice::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', "%" . $request->q . "%");
                    $q->orWhere('address', 'like', "%" . $request->q . "%");
                    $q->orWhere('type', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function($office) {
                return  ['id'=> $office->id, 'text' => $office->name];
            });
            return response()->json($offices);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
